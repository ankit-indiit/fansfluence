<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\ModelFilters\OrderFilter;
use App\Http\Services\CreateOrder;
use App\Http\Services\CreatePayment;
use App\Http\Services\DeliverOrder;
use App\Http\Services\ReviewService;
use Illuminate\Support\Facades\Crypt;
use App\Notifications\AcceptBuyerOrderNotification;
use App\Notifications\DeclineBuyerOrderNotification;
use App\Notifications\PaypalPaymentLinkNotification;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Genres;
use App\Models\UserGenres;
use App\Models\InfluencerPersonalize;
use App\Models\Review;
use App\Models\DeliverProduct;
use App\Models\InfluencerProfileDetail;
use App\Notifications\BuyerOrderStatus;
use Session;
use Auth;
use Response;
use DB;

class OrderController extends Controller
{
    public function index(Request $request, $role)
    {
        if ($role == 'buyer') {
            $orders = Order::filter($request->all())
                ->where('user_id', Auth::id())
                ->orderBy('id', 'DESC')
                ->get();
            return view('module.buyer.order', compact('orders'));
        }
        if ($role == 'influencer') {
            $orderIds = OrderDetail::where('influencer_id', Auth::id())
                ->pluck('order_id');
            $orders = Order::filter($request->all())
                ->whereIn('id', $orderIds)
                ->orderBy('id', 'DESC')
                ->get();
            return view('module.influencer.order', compact('orders'));   
        }
    }    

    public function show(Request $request, $orderId, $role)
    {
        $order = Order::where('id', $orderId)->first();       
        $influencer = User::findOrFail($order->orderDetail->influencer_id);
        if ($role == 'buyer') {
            $review = Review::where('influencer_id', $order->orderDetail->influencer_id)
                ->where('user_id', Auth::id())
                ->where('order_id', $order->id)
                ->first();
            return view('module.buyer.order-detail', compact('order', 'influencer', 'review'));
        }

        if ($role == 'influencer') {
            $review = Review::where('influencer_id', Auth::id())
                ->where('user_id', $order->orderDetail->user_id)
                ->where('order_id', $order->id)
                ->first();
            return view('module.influencer.order-detail', compact('order', 'influencer', 'review'));
        }
    }

    public function orderInfo(Request $request)
    {        
    	if (!empty($request->order_item)) {
            $productPrice = InfluencerPersonalize::where('influencer_id', $request->influencer_id)
                ->pluck($request->order_item)
                ->first();
            $productName = explode("_", $request->order_item)[0];            
            if ($productName == 'facebook' || $productName == 'instagram' || $productName == 'twitter') {
                $productMark = '';
            } else {
                $mark = str_replace("_", " ", $request->order_item);
                $productMark = str_replace($productName." ", "", $mark);
            }

            Session::put('product', [
                'product' => ucfirst($productName),
                'mark' => $productMark,
                'product_price' => $productPrice,
                'product_type' => $request->delevery_type,
                'influencer_id' => $request->influencer_id
            ]);
    	} else {
            return redirect()->back()->with('error', 'Please choose category!');
        }
        $influencer = User::findOrFail($request->influencer_id);
        $profileDetail = InfluencerProfileDetail::where('influencer_id', $request->influencer_id)
            ->first();
        return view('module.influencer.order-info', compact('influencer', 'profileDetail'));
    }

    public function saveOrderInfo(Request $request)
    {
        $request['visibility'] = $request->visibility == 'on' ? 1 : 0;        
        Session::put('orderDetail', $request->all());
        $influencer = User::findOrFail(Session::get('product')['influencer_id']);
        return view('module.influencer.payment', compact('influencer'));        
    }   

    public function acceptOrder(Request $request, CreatePayment $createPayment)
    {        
        DB::beginTransaction();
        
        try {

            $order = Order::where('id', $request->order_id)->first();
            $buyer = User::findOrFail($order->user_id);
            $order['influencer_id'] = $request->influencer_id;       
            $request['price'] = $order->product_price;
            $request['customer_id'] = $order->customer_id;        
            if ($order->payment_type == 'stripe') {
                $orderId = $createPayment->stripePayment($request);
                $buyer->notify(new AcceptBuyerOrderNotification($order));           
            }
            if ($order->payment_type == 'paypal') {            
                Order::where('id', $request->order_id)->update([
                    'status' => $request->status,
                    'decline_reasone' => $request->reasone,
                ]);
                $buyer->notify(new PaypalPaymentLinkNotification($order));
            }

            DB::commit();

            return redirect()->back()->with('success', 'Order Request has been accepted!');

        } catch (\Exception $e) {
            $message['message'] = $e->getMessage();
            DB::rollback();
            $message['erro'] = 101;
            return response()->json($message, 200);
        }        
    }

    public function declineOrder(Request $request, CreatePayment $createPayment)
    {
        DB::beginTransaction();
        
        try {

            $order = Order::where('id', $request->order_id)->first();
            $buyer = User::findOrFail($order->user_id);
            $order['influencer_id'] = $request->influencer_id;       
            $request['price'] = $order->product_price;
            $request['customer_id'] = $order->customer_id;
            if ($order->payment_type == 'stripe') {
                $orderId = $createPayment->stripePayment($request);                
                $buyer->notify(new DeclineBuyerOrderNotification($order));           
            }
            if ($order->payment_type == 'paypal') {
                Order::where('id', $request->order_id)->update([
                    'status' => $request->status,
                    'decline_reasone' => $request->reasone,
                ]);
                $buyer->notify(new DeclineBuyerOrderNotification($buyer));
            }

            DB::commit();

            return redirect()->back()->with('success', 'Order Request has been declined!');

        } catch (\Exception $e) {
            $message['message'] = $e->getMessage();
            DB::rollback();
            $message['erro'] = 101;
            return response()->json($message, 200);
        }        
    }    

    public function deliver(Request $request, DeliverOrder $deliverOrder)
    {
        $deliverOrder->create($request);
        return response()->json([
            'status' => true,
            'message' => 'Order has been successfully delivered!'
        ]);
    }

    public function buyerReview(Request $request, ReviewService $reviewService)
    {
        $validated = Validator::make($request->all(), [
            'rating' => 'required',
        ]);
        if ($validated->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validated->errors()->first(),
            ]);
        }
        $review = $reviewService->create($request);
        $reviewService->notification($review);
        return response()->json([
            'status' => true,
            'message' => 'Review has been successfully submitted!',
        ]);
    }

    public function downloadProduct(Request $request, $id)
    {
        $product = DeliverProduct::where('id', $id)->first();
        $product = public_path('order/')."".$product->product_name;
        return Response::download($product);
    }

    public function paypal(Request $request, $orderId)
    {
        $order = Order::where('id', $orderId)->first();
        if ($order->status == 'completed') {
            return redirect()->route('order', ['buyer', 'status' => 'completed']);
        }
        return view('module.buyer.paypal-payment', compact('order'));
    }

    // public function orderId()
    // {
    //     $ids = Order::orderBy('id', 'DESC')->pluck('id');
    //     foreach ($ids as $id) {
    //         $orderNo = date('Y').''.$id+1;
    //         Order::where('id', $id)->update(['order_id' => $orderNo]);
    //     }
    //     echo 'updated!';
    // }
}
