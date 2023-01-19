<?php

namespace App\Http\Services;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\AccountNotification;
use App\Models\User;
use Auth;
use DB;

class NotificationService
{
	public function create(Request $request)
    {
    	DB::beginTransaction();
        
        try {

        	if ($request->orderUpdate) {
        		AccountNotification::updateOrCreate([
        			'id' => $request->orderUpdateId,
        		],[
        			'user_id' => Auth::id(),
        			'name' => 'order_update',
        			'notification' => @$request->orderUpdate['notification'] ? $request->orderUpdate['notification'] : '0',
        			'email' => @$request->orderUpdate['email'] ? $request->orderUpdate['email'] : '0',
        			'mobile' => @$request->orderUpdate['mobile'] ? $request->orderUpdate['mobile'] : '0',
        		]);
        	}

        	if ($request->orderFinished) {
        		AccountNotification::updateOrCreate([
        			'id' => $request->orderFinishedId,
        		],[
        			'user_id' => Auth::id(),
        			'name' => 'order_finished',
        			'notification' => @$request->orderFinished['notification'] ? $request->orderFinished['notification'] : '0',
        			'email' => @$request->orderFinished['email'] ? $request->orderFinished['email'] : '0',
        			'mobile' => @$request->orderFinished['mobile'] ? $request->orderFinished['mobile'] : '0',
        		]);
        	}

        	if ($request->eventDiscount) {
        		AccountNotification::updateOrCreate([
        			'id' => $request->eventDiscountId,
        		],[
        			'user_id' => Auth::id(),
        			'name' => 'event_discount',
        			'notification' => @$request->eventDiscount['notification'] ? $request->eventDiscount['notification'] : '0',
        			'email' => @$request->eventDiscount['email'] ? $request->eventDiscount['email'] : '0',
        			'mobile' => @$request->eventDiscount['mobile'] ? $request->eventDiscount['mobile'] : '0',
        		]);
        	}

            if ($request->orderRecived) {
                AccountNotification::updateOrCreate([
                    'id' => $request->orderRecivedId,
                ],[
                    'user_id' => Auth::id(),
                    'name' => 'order_recived',
                    'notification' => @$request->orderRecived['notification'] ? $request->orderRecived['notification'] : '0',
                    'email' => @$request->orderRecived['email'] ? $request->orderRecived['email'] : '0',
                    'mobile' => @$request->orderRecived['mobile'] ? $request->orderRecived['mobile'] : '0',
                ]);
            }

            if ($request->reviewLeft) {
                AccountNotification::updateOrCreate([
                    'id' => $request->reviewLeftId,
                ],[
                    'user_id' => Auth::id(),
                    'name' => 'review_left',
                    'notification' => @$request->reviewLeft['notification'] ? $request->reviewLeft['notification'] : '0',
                    'email' => @$request->reviewLeft['email'] ? $request->reviewLeft['email'] : '0',
                    'mobile' => @$request->reviewLeft['mobile'] ? $request->reviewLeft['mobile'] : '0',
                ]);
            }		    	      

		DB::commit();

		} catch (\Exception $e) {
            $message['message'] = $e->getMessage();
            DB::rollback();
            $message['erro'] = 101;
            return response()->json($message, 200);
        }

	    return true;    	
    }

    public function show()
    {
    	$data = [];
    	$orderUpdate = AccountNotification::select('id', 'notification', 'email', 'mobile')
    		->where('user_id', Auth::id())
    		->where('name', 'order_update')
    		->first();
    	$orderFinished = AccountNotification::select('id', 'notification', 'email', 'mobile')
    		->where('user_id', Auth::id())
    		->where('name', 'order_finished')
    		->first();
    	$eventDiscount = AccountNotification::select('id', 'notification', 'email', 'mobile')
    		->where('user_id', Auth::id())
    		->where('name', 'event_discount')
    		->first();
        $orderRecived = AccountNotification::select('id', 'notification', 'email', 'mobile')
            ->where('user_id', Auth::id())
            ->where('name', 'order_recived')
            ->first();
        $reviewLeft = AccountNotification::select('id', 'notification', 'email', 'mobile')
            ->where('user_id', Auth::id())
            ->where('name', 'review_left')
            ->first();

    	return $data = [
    		'orderUpdate' => $orderUpdate,
    		'orderFinished' => $orderFinished,
    		'eventDiscount' => $eventDiscount,
            'orderRecived' => $orderRecived,
            'reviewLeft' => $reviewLeft,
    	];
    }
}
