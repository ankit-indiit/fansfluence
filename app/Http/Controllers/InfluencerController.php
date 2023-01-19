<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\UserService;
use App\Http\Services\InfluencerService;
use App\Http\Services\NotificationService;
use App\Models\User;
use App\Models\Genres;
use App\Models\UserGenres;
use App\Models\InfluencerProfileDetail;
use App\Models\InfluencerPersonalize;
use App\Models\InfluencerIntroPhoto;
use App\Models\OrderDetail;
use App\Models\Order;
use App\Models\DeliverySpeed;
use App\Models\RecentlyViewed;
use Session;
use Auth;
use File;

class InfluencerController extends Controller
{
    public function index(Request $request, $platform, $genres = '')
    {
        if ($genres) {            
            $genresId = Genres::where('name', $genres)
                ->pluck('id')
                ->first();
            $userIds = UserGenres::where('genres_id', $genresId)
                ->pluck('user_id');
            $users = User::filter($request->all())
                ->where('id', '!=', Auth::id())
                ->whereIn('id', $userIds)
                ->where('status', '1')
                ->where('primary_platform', $platform)
                ->paginate(20);            
        } else {
            $users = User::filter($request->all())
                ->where('id', '!=', Auth::id())
                ->where('status', '1')
                ->where('primary_platform', $platform)
                ->paginate(20);
        }
        return view('module.influencer.index', compact('users'));
    }

    public function show(Request $request, $id)
    {
        Session::forget('detail_for_payment');
        $user = User::where('id', $id)
            ->first();
        User::where('id', $id)
            ->update(['updated_at' => now()]);
        if (!RecentlyViewed::where('user_id', Auth::id())
                ->where('influencer_id', $id)
                ->exists()) {
            RecentlyViewed::create([
                'user_id' => Auth::id(),
                'influencer_id' => $id,
            ]);
        }
        $profileDetail = InfluencerProfileDetail::where('influencer_id', $id)
            ->first();
        $introPhotos = InfluencerIntroPhoto::where('influencer_id', $id)
            ->get();
        $profilePersonalize = InfluencerPersonalize::where('influencer_id', $id)
            ->first();       
        return view('module.influencer.show', compact('user', 'profileDetail', 'profilePersonalize', 'introPhotos'));
    }

    public function profile(Request $request)
    {
        $profileDetail = InfluencerProfileDetail::where('influencer_id', Auth::id())->first();
        $introPhotos = InfluencerIntroPhoto::where('influencer_id', Auth::id())->get();
        $personalize = InfluencerPersonalize::where('influencer_id', Auth::id())->first();
        $existPersonalize = InfluencerPersonalize::where('influencer_id', Auth::id())->exists();
        $deliverySpeed = DeliverySpeed::pluck('estimate', 'id')->toArray();
        return view('module.user.influencer.profile', compact('profileDetail', 'introPhotos', 'personalize', 'deliverySpeed', 'existPersonalize'));
    }

    public function earning(Request $request)
    {
        $orderIds = OrderDetail::where('influencer_id', Auth::id())
            ->pluck('order_id');
        $pendingFunds = Order::filter($request->all())
            ->whereIn('id', $orderIds)
            ->where('status', 'pending')
            ->get();
        $settledFunds = Order::filter($request->all())
            ->whereIn('id', $orderIds)
            ->where('status', 'completed')
            ->get();
        return view('module.user.influencer.earning', compact('pendingFunds', 'settledFunds'));
    }   

    public function updateProfileCategory(Request $request, InfluencerService $influencerService)
    {
        return $influencerService->updateProfileCat($request); 
    }

    public function updateProfileDetail(Request $request, InfluencerService $influencerService)
    {
        return $influencerService->updateInfluencerDetail($request); 
    }

    public function uploadIntroVideo(Request $request)
    {        
        if ($request->hasFile('introVideo')) {
            $video = $request->file('introVideo');
            $videoName = time() . '.' . $video->getClientOriginalExtension();
            $destinationPath = public_path('/influencer');
            $video->move($destinationPath, $videoName);
        } else {
            $videoName = $request->existVideoName;
        }   
        $introVideo = InfluencerProfileDetail::updateOrCreate([
            'influencer_id' => Auth::id()
        ],[
            'intro_video' => $videoName,            
        ]);
        if (isset($request->existVideoName) && File::exists(public_path("/influencer/$request->existVideoName"))) {
            unlink(public_path("/influencer/$request->existVideoName"));
        }
        if ($introVideo == true) {
            return response()->json([
                'status' => true,
                'video' => asset("influencer/$videoName"),
                'message' => 'Video has been uploaded!',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong please try again!',
            ]);
        }
    }

    public function uploadIntroPhotos(Request $request)
    {
        $introPhotos = '';
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();        
        $image->move(public_path('influencer'),$imageName);
        InfluencerIntroPhoto::create([
            'influencer_id' => Auth::id(),
            'name' => $imageName,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Photo uploaded!',
        ]);
    }

    public function removeIntroPhoto(Request $request)
    {
        if (isset($request->id)) {
            $file = $request->image;
            InfluencerIntroPhoto::where('id', $request->id)
                ->delete();
        } else {
            $file = $request->name;
            InfluencerIntroPhoto::where('influencer_id', Auth::id())
                ->where('name', $request->name)
                ->delete();
        }

        if(isset($file)){
            unlink("influencer/".$file);
        }       
        return response()->json([
            'status' => true,
            'message' => 'Photo Deleted!',
        ]);
    }

    public function profileStatus(Request $request, UserService $userService)
    {
        return $userService->updateProfileStatus($request);               
    }

    public function stars(Request $request, $platform)
    {
        $users = getInfluencers($platform);
        return view('module.influencer.influencers', compact('users'));
    }
}
