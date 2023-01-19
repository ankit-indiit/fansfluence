<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\InfluencerPersonalize;
use Validator;
use Auth;
use DB;

class AdminGigController extends Controller
{
    public function index(Request $request)
    {
        $gigs = InfluencerPersonalize::get();
        if($request->ajax()){
            $userIds = User::where('name', 'like', '%' . $request->search . '%')->pluck('id')->toArray();
            $gigs = InfluencerPersonalize::whereIn('influencer_id', $userIds)->get();
            return response()->json([
                'status' => true,
                'gigs' => view('admin.component.seller-gigs', ['gigs' => $gigs])->render()
            ]);            
        }
        return view('admin.gigs.index', compact('gigs'));  
    }

    public function edit(Request $request)
    {
        $gig = InfluencerPersonalize::where('influencer_id', $request->influencer_id)->first();        
        return response()->json([
            'status' => true,
            'id' => @$gig->id,
            'photo_with_watermark' => @$gig->photo_with_watermark,
            'photo_with_out_watermark' => @$gig->photo_with_out_watermark,
            'video_with_watermark' => @$gig->video_with_watermark,
            'video_with_out_watermark' => @$gig->video_with_out_watermark,
            'facebook_price' => @$gig->facebook_price,
            'instagram_price' => @$gig->instagram_price,
            'twitter_price' => @$gig->twitter_price,
        ]);
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        
        try {

            InfluencerPersonalize::where('id', $request->id)->update($request->except('_token'));
            
            DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Gig has been updated!',
        ]);

        } catch (\Exception $e) {
            $message['message'] = $e->getMessage();
            DB::rollback();
            $message['erro'] = 101;
            return response()->json($message, 200);
        } 
    }
}