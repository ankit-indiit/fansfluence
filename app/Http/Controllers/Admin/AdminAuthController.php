<?php
namespace App\Http\Controllers\Admin;

use Validator;
use Session;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $redirectTo = '/admin/login';

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function getLogin()
    {
        return view('admin.login');
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (auth()->guard('admin')->attempt([
            'email' => $request->input('email'), 
            'password' => $request->input('password')
        ])) {

            $user = auth()->guard('admin')->user();            
            return redirect()->route('dashboard')->with('success','Logged in successfully.');
            
        } else {
            return back()->with('error','your username and password are wrong.');
        }
    }

    public function logout()
    {
        auth()->guard('admin')->logout();
        return redirect()->route('adminLogin')->with('success','Logged out.');      
    }
}