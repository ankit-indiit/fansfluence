<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use App\Http\Services\UserService;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use App\Models\Genres;
use App\Models\UserGenres;
use App\Models\InfluencerProfileDetail;
use App\Models\InfluencerIntroPhoto;
use App\Models\InfluencerPersonalize;
use App\Models\LinkBankAccount;
use Notification;
use App\Notifications\AdminNotification;
use Session;
use Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        
    }

    public function login(UserLoginRequest $request, UserService $userService)
    {
        return $userService->loginUser($request);              
    }

    public function register(UserRegisterRequest $request, UserService $registerUserService)
    {
        $registerUserService->createUser($request);      
        return response()->json([
            'status' => true,
            'message' => 'You have successfully registered!'
        ]);
    }

    public function store(UserRequest $request, UserService $userService)
    {
    	$userService->createInfluencer($request);
        return response()->json([
            'status' => true,
            'message' => 'You have successfully registered!'
        ]);
    }

    public function mailVerification(Request $request, UserService $userService, $token)
    {
        $request['token'] = $token;
        $emailVerify = $userService->verification($request);
        if ($emailVerify == true) {
            return redirect()->route('login')->with('success', 'Your Email has been verified!');
        } 
    }

    public function account(Request $request)
    {
        return view('module.user.account');
    }
   
    public function profilePic(Request $request, UserService $userService)
    {
        return $userService->uploadInfluencerProfile($request);         
    }

    public function updateProfile(Request $request, UserService $userService)
    {
        return $userService->updateInfluencerProfile($request);               
    }    

    public function searchBox(Request $request)
    {
        $users = User::select('name', 'image')
            ->where('status', '1')
            ->where('name', 'like', '%' . $request->search . '%')
            ->get();
        $list = '';
        foreach ($users as $user) {
            $list .= '<li>
                <div class="d-flex align-items-center">
                    <div class="main-img-user">
                        <img alt="avatar" src="'.$user->image.'">
                    </div>
                    <div class="notification-body">
                        <p class="name-list" data-name="'.$user->name.'">'.$user->name.'</p>
                    </div>
                </div>
            </li>'; 
        }
        if (count($users) > 0) {
            $list = $list;
        } else {
            $list = '<li>
                <div class="d-flex align-items-center">
                    <div class="notification-body">
                        <p class="name-list">No user found!</p>
                    </div>
                </div>
            </li>';
        }
        if ($request->search != '') {
            return response()->json([
                'status' => true,
                'data' => $list,
            ]);            
        } else {
            return response()->json([
                'status' => false,
                'data' => '',
            ]);
        }
    }

    public function search(Request $request)
    {
        $users = User::select('id', 'name', 'image')
            ->filter($request->all())
            ->where('status', '1')
            ->where('name', 'like', '%' . $request->search . '%')
            ->paginate(10); 
        return view('module.search', compact('users'));
    }

    public function business(Request $request)
    {
        $business = User::where('id', Auth::id())->update([
            'business' => $request->status
        ]);
        if ($business == true) {            
            return response()->json([
                'status' => true,
                'message' => 'Account status has been updated!',
            ]);
        }
    }

    public function businessFilter(Request $request)
    {
        if ($request->status == 1) {
            Session::put('business', true);
        } else {
            Session::forget('business');
        }
        return response()->json([
            'status' => true,
            'message' => 'Account status has been updated!',
        ]);
    }

    public function linkBank(Request $request)
    {
        $account = LinkBankAccount::where('user_id', Auth::id())->first();
        return view('module.user.link-bank-account', compact('account'));        
    }

    public function linkBankAcc(Request $request)
    {
        $request['user_id'] = Auth::id();
        $account = LinkBankAccount::updateOrCreate([
            'id' => $request->id,
        ], $request->all());
        if ($account == true) {            
            return response()->json([
                'status' => true,
                'message' => 'Account has been linked!',
            ]);
        }
    }
}
