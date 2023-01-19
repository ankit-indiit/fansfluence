<?php
   
namespace App\Http\Controllers;
   
use Illuminate\Http\Request;
use App\Http\Services\CreatePayment;
use App\Http\Services\CreateOrder;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Notifications\BuyerOrder;
use App\Notifications\SellerOrder;
use App\Notifications\AdminOrderNotification;
use Session;
use Stripe;
use Auth;
use DB;
   
class StripeController extends Controller
{    
    public function stripePost(Request $request, CreateOrder $createOrder)
    {
        DB::beginTransaction();

        try {
        
            Stripe\Stripe::setApiKey(env('STRIPE_TEST_SECRET'));
            $customerId = Auth::user()->stripe_customer_id;
            if (isset($customerId)) {
                $request['id'] = $customerId;
            } else {
                $customer = Stripe\Customer::create([
                    'email' => Auth::user()->email,
                    'name' => Auth::user()->name,
                    "source" => $request->stripeToken,
                    'description' => $request->product.' '.$request->mark,
                ]);
                User::where('id', Auth::id())->update([
                    'stripe_customer_id' => $customer->id,
                ]);
                $request['id'] = $customer->id;
            }
            $request['payment_type'] = 'stripe';
            // Save order detal
            $orderId = $createOrder->create($request);
            $createOrder->notification($orderId);
            Session::forget('product');
            Session::forget('orderDetail');

            DB::commit();

            return redirect()
                ->route('order', ['buyer', 'status' => 'pending'])
                ->with('success', 'Your order request has been sent!');

            // return response()->json([
            //     'status' => true,
            //     'message' => 'Your order request has been sent!',
            //     'link' => route('order', ['buyer', 'status' => 'pending']),
            // ]);

        } catch (\Exception $e) {
            $message['message'] = $e->getMessage();
            DB::rollback();
            $message['erro'] = 101;
            return response()->json($message, 200);
        }         
    }
}