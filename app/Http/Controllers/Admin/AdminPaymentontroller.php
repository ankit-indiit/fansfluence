<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Models\PaymentMethod;
use Validator;
use Auth;
use DB;

class AdminPaymentontroller extends Controller
{
    public function create(Request $request, $type)
    {
        $payment = PaymentMethod::where('type', $type)->first();
        if ($type == 'paypal') {
            return view('admin.payment.paypal', compact('payment'));  
        }

        if ($type == 'stripe') {
            return view('admin.payment.stripe', compact('payment'));  
        }
    }

    public function store(Request $request)
    {       
        DB::beginTransaction();
        
        try {

            PaymentMethod::updateOrCreate(['id' => $request->id], $request->all());
            
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Payment method has been saved!',
            ]);

        } catch (\Exception $e) {
            $message['message'] = $e->getMessage();
            DB::rollback();
            $message['erro'] = 101;
            return response()->json($message, 200);
        }
    }    
}