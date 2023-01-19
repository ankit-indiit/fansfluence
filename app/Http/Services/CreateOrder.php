<?php

namespace App\Http\Services;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Notifications\BuyerOrderRequest;
use App\Notifications\SellerOrderRequest;
use App\Notifications\AdminOrderNotification;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use Session;
use Auth;
use DB;

class CreateOrder
{
	public function create(Request $request)
    {
    	DB::beginTransaction();
        
        try {
        	$id = Order::orderBy('id', 'DESC')->pluck('id')->first();
        	$orderNo = date('Y').''.$id+1;
		    $order = Order::create([
		        'user_id' => Auth::id(),
		        'order_id' => $orderNo,
		        'customer_id' => $request->id,
		        'payment_type' => $request->payment_type,
		        'product' => Session::get('product')['product'],
		        'mark' => Session::get('product')['mark'],
		        'product_price' => Session::get('product')['product_price'],
		        'status' => 'pending',
		    ]);

		    OrderDetail::create([
		    	'order_id' => $order->id,
		    	'user_id' => Auth::id(),
		    	'influencer_id' => Session::get('product')['influencer_id'],
		    	'detail' => serialize(Session::get('orderDetail')),
		    	'visibility' => Session::get('orderDetail')['visibility'],
		    ]);    

		DB::commit();

	    return $order->id;    	

		} catch (\Exception $e) {
            $message['message'] = $e->getMessage();
            DB::rollback();
            $message['erro'] = 101;
            return response()->json($message, 200);
        }
    }

    public function notification($orderId)
    {
    	DB::beginTransaction();
        
        try {		 
           
        	$order = Order::where('id', $orderId)->first();
        	$buyer = Auth::user();
            $seller = User::findOrFail(Session::get('product')['influencer_id']);        	

		    $buyer['message'] = "Your order request <strong>".$order->product_name."</strong> has been successfully placed to  <strong>".$seller->name."</strong>";
		    $buyer['user_id'] = Auth::id();		      
		    $buyer['link'] = route('order', 'buyer').'?status=pending';     
		    $buyer->notify(new BuyerOrderRequest($buyer));

		    // Trigger Mail And Notification to Seller
		    $seller['message'] = "You've received a <strong>".$order->product_name."</strong> request from <strong>".$buyer->name."</strong>";
		    $seller['user_id'] = $buyer->id;		    
		    $seller['link'] = route('order', 'influencer').'?status=pending';   
		    $seller->notify(new SellerOrderRequest($seller));

		    // Trigger Mail And Notification to Admin
		    $admin = User::where('email', env("ADMIN_MAIL"))->first();
		    $admin['message'] = "<strong>$seller->name</strong> has received a <strong>$order->product_name</strong> request from <strong>$buyer->name</strong>";
		    $admin['user_id'] = $buyer->id;       
		    $admin['influencer_id'] = $seller->id;
		    $admin['mail'] = $admin->alert('order_update', 'email');       
		    $admin['notification'] = $admin->alert('order_update', 'notification'); 
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
