<?php

namespace App\Http\Services;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Notifications\ReviewNotification;
use App\Models\User;
use App\Models\Order;
use App\Models\Review;
use DB;
use Auth;

class ReviewService
{
	public function create(Request $request): Review
    {
    	DB::beginTransaction();
        
        try {

		    $review = Review::create($request->all());
		    Order::where('id', $request->order_id)->update([
		    	'status' => 'completed',
		    ]);	   

			DB::commit();

		} catch (\Exception $e) {
            $message['message'] = $e->getMessage();
            DB::rollback();
            $message['erro'] = 101;
            return response()->json($message, 200);
        }

	    return $review;    	
    }

    public function notification($review)
    {
    	DB::beginTransaction();
        
        try {

	    	$buyer = User::where('id', $review->user_id)->first();
	    	$influencer = User::where('id', $review->influencer_id)->first();
		    
	    	// Submit review notification to Influencer
	    	$influencer['subject'] = 'Fansfluence Thank You For Review!';
	    	if (isset($review->review)) {
	    		$influencer['message'] = '<strong>'.$buyer->name.'</strong> has left a <strong>'.$review->rating.' star</strong> review <br> "'.$review->review.'"';
	    	} else {
	    		$influencer['message'] = '<strong>'.$buyer->name.'</strong> has left a <strong>'.$review->rating.' star</strong>';
	    	}
	    	$influencer['link'] = route('order.detail', [$review->order_id, 'influencer']);   
	    	$influencer['user_id'] = $review->influencer_id;
	    	$influencer['mail'] = $influencer->alert('review_left', 'email');       
		    $influencer['notification'] = $influencer->alert('review_left', 'notification');   
	    	$influencer->notify(new ReviewNotification($influencer));

		DB::commit();

		} catch (\Exception $e) {
            $message['message'] = $e->getMessage();
            DB::rollback();
            $message['erro'] = 101;
            return response()->json($message, 200);
        }    	
    }
}
