<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\CreatePayment;
use App\Http\Services\CreateOrder;
use Illuminate\Support\Facades\Crypt;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Notifications\BuyerOrder;
use App\Notifications\SellerOrder;
use App\Notifications\AdminOrderNotification;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use Session;
use Auth;
use DB;

class PayPalController extends Controller
{    
    public function request(Request $request, CreateOrder $createOrder)
    {
        DB::beginTransaction();

        try {
        
            $request['payment_type'] = 'paypal';        
            $orderId = $createOrder->create($request);
            $createOrder->notification($orderId);
            Session::forget('product');           
            Session::forget('orderDetail');

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Your order request has been sent! Once your request accepted by the influencer, You will get the payment link on your registered email to process with the payment.',
                'link' => route('order', ['buyer', 'status' => 'pending']),
            ]);

        } catch (\Exception $e) {
            $message['message'] = $e->getMessage();
            DB::rollback();
            $message['erro'] = 101;
            return response()->json($message, 200);
        }        
    }

    public function process(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('successTransaction'),
                "cancel_url" => route('cancelTransaction'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $request->price
                    ]
                ]
            ]
        ]);        

        if (isset($response['id']) && $response['id'] != null)
        {
            Session::put('payment', [
                'payment_id' => $response['id'],
                'order_id' => $request->order_id,
            ]);
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }

            return redirect()
                ->back()
                ->with('error', 'Something went wrong.');

        } else {
            return redirect()
                ->back()
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    public function success(Request $request)
    {        
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);        

        if (isset($response['status']) && $response['status'] == 'COMPLETED')
        {
            Order::where('id', Session::get('payment')['order_id'])->update([
                'customer_id' => Session::get('payment')['payment_id'],
                'status' => 'accept',
            ]);
            $order = Order::findOrFail(Session::get('payment')['order_id']);
            $influencerId = OrderDetail::where('order_id', Session::get('payment')['order_id'])
                ->pluck('influencer_id')
                ->first();
            $buyer = Auth::user();
            $seller = User::findOrFail($influencerId);
            $seller['message'] = "Payment created by <strong>".$buyer->name."</strong> for <strong>".$order->product_name."<strong>";
            $seller['user_id'] = $buyer->id;
            $seller['mail'] = $seller->alert('order_finished', 'email');       
            $seller['notification'] = $seller->alert('order_update', 'notification'); 
            $seller['link'] = route('order.detail', [$order->id, 'influencer']);    
            $seller->notify(new SellerOrder($seller));
            Session::forget('payment');
            
            return redirect()
                ->route('order', ['buyer', 'status' => 'accept'])
                ->with('success', 'Transaction complete.');
        
        } else {
            
            return redirect()
                ->back()
                ->with('error', $response['message'] ?? 'Something went wrong.');
        
        }
    }

    public function cancel(Request $request)
    {
        return redirect()
            ->back()
            ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }
}