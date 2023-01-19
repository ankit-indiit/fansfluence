<?php

namespace App\Http\Services;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Notifications\AdminNotification;
use App\Notifications\MailVerficationNotification;
use App\Notifications\UserRegistered;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserGenres;
use Auth;
use DB;

class UserService
{
	public function createInfluencer(Request $request)
    {
        try {

        	$user = User::where('email', $request->email)->first();
        	if ($user) {
        		User::where('id', $user->id)->update($request->except(['_token', 'name', 'email', 'confirm_email', 'reaching_out_us', 'genres']));
        		$user->assignRole('influencer');
			    $user['role'] = 'influencer';    
        	} else {
			    $user = User::create([
			        'name' => $request->name,
			        'email' => $request->email,
			        'password' => Hash::make(12345),
			        'question_description' => $request->question_description,
			        'primary_platform' => $request->primary_platform,
			        'anything_else' => $request->anything_else,
			    ]);
			    $user->assignRole('influencer');
			    $user['role'] = 'influencer';
        	}
            
		    if (count($request->genres) > 0) {
	            foreach ($request->genres as $genresId) {
	                if ($genresId) {
	                    UserGenres::create([
	                        'user_id' => $user->id,
	                        'genres_id' => $genresId,
	                    ]);
	                }
	            }
	        }
            
	        $admin = User::where('email', env("ADMIN_MAIL"))->first();	        
    		$admin->notify(new AdminNotification($user));
            $user->notify(new UserRegistered($user));

			DB::commit();

		} catch (\Exception $e) {
            $message['message'] = $e->getMessage();
            DB::rollback();
            $message['erro'] = 101;
            return response()->json($message, 200);
        }
        return true;
    }

    public function createUser(Request $request)
    {
    	DB::beginTransaction();
        
        try {

		    $user = User::create([
		        'name' => $request->name,
		        'email' => $request->email,
		        'password' => Hash::make($request->password),		        
		        'token' => Str::random(64),		        
		    ]);
		    $user->assignRole('buyer');
		    $user['role'] = 'buyer';
		    $user['link'] = route('mailVerification', $user->token);
	        $admin = User::where('email', env("ADMIN_MAIL"))->first();      
    		$admin->notify(new AdminNotification($user));
    		$user->notify(new MailVerficationNotification($user));

			DB::commit();

		} catch (\Exception $e) {
            $message['message'] = $e->getMessage();
            DB::rollback();
            return response()->json($message, 200);
        }
        return true;
    }    

    public function verification(Request $request)
    {
        return User::where('token', $request->token)->update([
        	'email_verified_at' => now(),
        ]);        
    }

    public function loginUser(Request $request)
    {
        if (!User::where('email', $request->email)->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'User does not exist!',
            ]);
        }
    	$credentials = $request->only('email', 'password');
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        	if (Auth::user()->email_verified_at == '') {
        		Auth::logout();
        		$status = false;
	            $link = route('userLogin');
	        	$message = 'Please verify your email first!';
        	} else {
	            $status = true;
	            $link = route('home');
	        	$message = 'You have successfully logged in';
        	}         
        } else {
        	$status = false;
        	$link = route('userLogin');
        	$message = 'Oppes! You have entered invalid credentials';
        }

        return response()->json([
            'status' => $status,
            'link' => $link,
            'message' => $message
        ]);
    }

    public function updateInfluencerProfile(Request $request)
    {       
        if ($request->current_password != '' && $request->new_password != '' && $request->confirm_password != '') {
            if ($request->new_password != $request->confirm_password) {
                $status = false;
                $message = 'New password and confirm password must be same!';
            } else {
                $user = User::findOrFail(Auth::user()->id);
                if (Hash::check($request->current_password, $user->password)) {
                    $request['password'] = Hash::make($request->confirm_password);
                    User::where('id', Auth::user()->id)->update($request->except(
                        '_token', 'current_password', 'new_password', 'confirm_password'
                    ));
                    $status = true;
                    $message = 'Profile has been updated!';
                } else {
                    $status = false;
                    $message = 'Your current password is invalid!';
                }
            }
        } else {
            User::where('id', Auth::user()->id)->update($request->except(
                '_token', 'current_password', 'new_password', 'confirm_password'
            ));
            $status = true;
            $message = 'Profile has been updated!';
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }

    public function uploadInfluencerProfile(Request $request)
    {
        if ($request->file('userProfilePic')) {
            $image = $request->file('userProfilePic');
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/user');
            $image->move($destinationPath, $imagename);
            User::where('id', Auth::user()->id)->update([
                'image' => $imagename,
            ]);
            if ($request->image_name) {                
                unlink("user/".$request->image_name);
            }
        }
        return response()->json([
            'status' => true,
            'image' => asset("user/$imagename"),
            'image_name' => $imagename,
            'message' => 'Profile picture has been uploaded!',
        ]);
    }

    public function updateProfileStatus(Request $request)
    {
        User::where('id', Auth::id())->update([
            'status' => $request->status,
        ]);       
        return response()->json([
            'status' => true,
            'message' => 'Profile status has been updated!',
        ]);
    }
}
