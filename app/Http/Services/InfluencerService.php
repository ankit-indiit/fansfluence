<?php

namespace App\Http\Services;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\StaredInfluencer;
use App\Models\InfluencerProfileDetail;
use App\Models\InfluencerPersonalize;
use Auth;
use DB;

class InfluencerService
{
	public function star(Request $request)
    {
    	DB::beginTransaction();
        
        try {

	    	StaredInfluencer::create($request->all());	    	

			DB::commit();

		    return response()->json([
	            'status' => true,
	            'message' => 'This influencer has been added in your collection!'
	        ]);

		} catch (\Exception $e) {
            $message['status'] = false;
            $message['message'] = $e->getMessage();
            DB::rollback();
            return response()->json($message, 200);
        }
    }

    public function unStar(Request $request)
    {
    	DB::beginTransaction();
        
        try {

	    	StaredInfluencer::where('collection_id', $request->collection_id)
	    		->where('influencer_id', $request->influencer_id)
	    		->delete();	    	
		   
			DB::commit();

		    return response()->json([
	            'status' => true,
	            'message' => 'This influencer has been removed from collection!'
	        ]);

		} catch (\Exception $e) {
            $message['status'] = false;
            $message['message'] = $e->getMessage();
            DB::rollback();
            return response()->json($message, 200);
        }
    }

    public function updateInfluencerDetail(Request $request)
    {
    	DB::beginTransaction();
        
        try {		    	              

	        InfluencerProfileDetail::updateOrCreate([
        		'influencer_id' => Auth::id()
        	],[
        		'influencer_id' => Auth::id(),
	        	'about' => $request->about,
	        	'photo_question' => $request->photoClientQues == 'photo' ? serialize($request->photo) : NULL,
	        	'video_question' => $request->videoClientQues == 'video' ? serialize($request->video) : NULL,
	        	'post_question' => $request->mediaClientQues == 'media' ? serialize($request->media) : NULL,
	        	'twitter' => $request->twitter,
	        	'facebook' => $request->facebook,
	        	'instagram' => $request->instagram,
	        	'youtube' => $request->youtube,
	        	'tiktok' => $request->tiktok,
	        	'twitch' => $request->twitch,
	        	'delivery_speed' => $request->delivery_speed,
        	]); 	       

			DB::commit();

		    return response()->json([
	            'status' => true,
	            'message' => 'Profile detail has been updated successfully!',
	        ]);

		} catch (\Exception $e) {
            $message['status'] = false;
            $message['message'] = $e->getMessage();
            DB::rollback();
            return response()->json($message, 200);
        }
    }

    public function updateProfileCat(Request $request)
    {
    	$photoWithWatermark = $request->personalizedPhoto == 'photo' ? $request->photo_with_watermark : '';
    	$photoWithOutWatermark = $request->personalizedPhoto == 'photo' ? $request->photo_with_out_watermark : '';
    	$videoWithWatermark = $request->personalizedVideo == 'video' ? $request->video_with_watermark : '';
    	$videoWithOutWatermark = $request->personalizedVideo == 'video' ? $request->video_with_out_watermark : '';
    	$facebookPrice = $request->socialMediaPost == 'media' ? $request->facebook_price : '';
    	$instagramPrice = $request->socialMediaPost == 'media' ? $request->instagram_price : '';
    	$twitterPrice = $request->socialMediaPost == 'media' ? $request->twitter_price : '';

    	try {

	    	InfluencerPersonalize::updateOrCreate([
	    		'influencer_id' => Auth::id()
	    	],[
	    		'influencer_id' => Auth::id(),
	    		'photo_with_watermark' => $photoWithWatermark,
	    		'photo_with_out_watermark' => $photoWithOutWatermark,
	    		'video_with_watermark' => $videoWithWatermark,
	    		'video_with_out_watermark' => $videoWithOutWatermark,
	    		'facebook_price' => $facebookPrice,
	    		'instagram_price' => $instagramPrice,
	    		'twitter_price' => $twitterPrice,
	    		'photo_type' => $request->photoDeliveryType,
	    		'video_type' => $request->videoDeliveryType,
	    	]);
	    	$price = InfluencerPersonalize::where('influencer_id', Auth::id())->first();
	    	User::where('id', Auth::id())->update([
    			'min_price' => min($price->check_cat),
    		]);

    		DB::commit();

		    return response()->json([
	            'status' => true,
	            'message' => 'Profile category has been updated!',
	        ]);

		} catch (\Exception $e) {
            $message['status'] = false;
            $message['message'] = $e->getMessage();
            DB::rollback();
            return response()->json($message, 200);
        }  
    }
}
