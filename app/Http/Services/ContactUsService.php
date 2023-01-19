<?php

namespace App\Http\Services;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Notifications\ContactUsNotification;
use App\Models\ContactUs;
use App\Models\User;
use DB;

class ContactUsService
{
	public function createContactUs(Request $request)
    {
    	DB::beginTransaction();
        
        try {

		    $contact = ContactUs::create($request->all());

	        $admin = User::where('email', env("ADMIN_MAIL"))->first();	        
			$admin->notify(new ContactUsNotification($contact));

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
