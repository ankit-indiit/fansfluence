<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Order;
use Validator;
use Auth;
use DB;

class AdminInvoiceController extends Controller
{
    public function index(Request $request)
    {
        $payments = Order::orderBy('id', 'DESC')->get();              
        return view('admin.manage-payment.index', compact('payments'));  
    }
}