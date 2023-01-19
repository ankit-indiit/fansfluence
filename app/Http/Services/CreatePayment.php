<?php

namespace App\Http\Services;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Notifications\BuyerOrder;
use App\Notifications\SellerOrder;
use App\Notifications\AdminOrderNotification;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use Stripe;
use Auth;
use DB;

class CreatePayment
{
	public function stripePayment(Request $request)
    {
    	DB::beginTransaction();
        
        try {

        	Stripe\Stripe::setApiKey(env('STRIPE_TEST_SECRET'));
	        Stripe\Charge::create([
	            "customer" => $request->customer_id,
	            "amount"   => $request->price * 100,
	            "currency" => "usd",
	            "description" => "This is test description!",
	        ]);

		    Order::where('id', $request->order_id)->update([
	            'status' => $request->status,
	            'decline_reasone' => $request->reasone,
	        ]);		  

			DB::commit();

		} catch (\Exception $e) {
            $message['message'] = $e->getMessage();
            DB::rollback();
            $message['erro'] = 101;
            return response()->json($message, 200);
        }

	    return $request->order_id;    	
    }

    public function notification($orderId)
    {
    	DB::beginTransaction();
        
        try {		    

        	$order = Order::where('id', $orderId)->first();
		    $buyer = User::where('id', $order->user_id)->first();
		    $seller = User::where('id', $order->orderDetail->influencer_id)->first();
		    $admin = User::where('email', env("ADMIN_MAIL"))->first();
		    
	        // Trigger Mail And Notification to Buyer
		    $buyer['message'] = "<strong>".$seller->name."</strong> has ".$order->status." your business photo";
		    $buyer['user_id'] = Auth::id();       
		    $buyer['mail'] = $buyer->alert('order_finished', 'email');       
		    $buyer['notification'] = $buyer->alert('order_finished', 'notification');
		    if ($order->payment_type == 'stripe') {
		    	$buyer['link'] = route('order', 'buyer').'?status=completed';
		    } else {
		    	$buyer['link'] = route('order.paypal', $order->id);
		    }    
		    $buyer->notify(new BuyerOrder($buyer));

		    // Trigger Mail And Notification to Seller
		    if ($order->status == 'accept') {
		    	if ($order->payment_type == 'paypal') {
		    		$seller['message'] = "Payment link has been sent to <strong>".$buyer->name."</strong> for <strong>".$order->product_name."<strong>";
		    	} else {
			    	$seller['message'] = "Payment created by <strong>".$buyer->name."</strong> for <strong>".$order->product_name."<strong>";
		    	}
			    $seller['user_id'] = $buyer->id;
			    $seller['mail'] = $seller->alert('order_finished', 'email');       
			    $seller['notification'] = $seller->alert('order_finished', 'notification'); 
			    $seller['link'] = route('order.detail', [$order->id, 'influencer']);    
			    $seller->notify(new SellerOrder($seller));
		    }

		    // Trigger Mail And Notification to Admin
		    $admin['message'] = "<strong>".$buyer->name."</strong> has created payment of product <strong>".$seller->name."</strong> prduct <strong>".$order->product_name."</strong>";
		    $admin['user_id'] = $buyer->id;       
		    $admin['influencer_id'] = $seller->id;
		    $admin['mail'] = $admin->alert('order_finished', 'email');       
		    $admin['notification'] = $admin->alert('order_finished', 'notification'); 
		    $admin->notify(new AdminOrderNotification($admin));

		DB::commit();

		} catch (\Exception $e) {
            $message['message'] = $e->getMessage();
            DB::rollback();
            $message['erro'] = 101;
            return response()->json($message, 200);
        }

	    return true;  
    }
}
