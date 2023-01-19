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
use App\Models\DeliverProduct;
use Session;
use Auth;
use DB;

class DeliverOrder
{
	public function create(Request $request)
    {    	
    	DB::beginTransaction();
        
        try {

		    if ($request->hasFile('product')) {
	            $product = $request->file('product');
	            $productName = time() . '.' . $product->getClientOriginalExtension();
	            $destinationPath = public_path('/order');
	            $product->move($destinationPath, $productName);
	        }

	        Order::where('id', $request->order_id)->update([
	        	'status' => 'delivered'
	        ]);

	        DeliverProduct::create([
	        	'order_id' => $request->order_id,
	        	'product' => $productName,
	        	'type' => $request->type,
	        ]);
	        $order = Order::where('id', $request->order_id)->first();
		    $this->notification($order);    

		DB::commit();

		} catch (\Exception $e) {
            $message['message'] = $e->getMessage();
            DB::rollback();
            $message['erro'] = 101;
            return response()->json($message, 200);
        }

	    return true;    	
    }

    public function notification($order)
    {
    	DB::beginTransaction();
        
        try {		    

		    $buyer = User::where('id', $order->user_id)->first();
	        $seller = User::where('id', Auth::id())->first();

		    $buyer['message'] = "<strong>".$seller->name."</strong> has deliver your order <strong>".$order->product_name."</strong>!";
		    $buyer['user_id'] = Auth::id();
		    $buyer['mail'] = $buyer->alert('order_finished', 'email');       
		    $buyer['notification'] = $buyer->alert('order_finished', 'notification');  
		    $buyer['link'] = route('order', 'buyer').'?status=delivered';        
		    $buyer->notify(new BuyerOrder($buyer));

		    // Trigger Mail And Notification to Seller
		    $seller['message'] = "You'v deliver <strong>".$order->product_name."</strong> of <strong>".$buyer->name."</strong>";
		    $seller['user_id'] = $buyer->id;
		    $seller['mail'] = $seller->alert('order_finished', 'email');       
		    $seller['notification'] = $seller->alert('order_finished', 'notification');  
		    $seller['link'] = route('order.detail', [$order->id, 'influencer']);    
		    $seller->notify(new SellerOrder($seller));

		    // Trigger Mail And Notification to Admin
		    $admin = User::where('email', env("ADMIN_MAIL"))->first();
		    $admin['message'] = "<strong>".$seller->name."</strong> has deliver <strong>".$order->product_name."</strong> of <strong>".$buyer->name."</strong>";
		    $admin['user_id'] = $buyer->id;
		    $admin['mail'] = $admin->alert('order_finished', 'email');       
		    $admin['notification'] = $admin->alert('order_finished', 'notification');    
		    $admin['influencer_id'] = $seller->id;
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
