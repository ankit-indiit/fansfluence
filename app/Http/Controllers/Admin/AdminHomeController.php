<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use App\Models\Admin;
use App\Models\User;
use App\Models\Order;
use Validator;
use Session;
use DB;

class AdminHomeController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('email', '!=', 'developerindiit@gmail.com')->count();
        $seller = User::role('influencer')->count();
        $order = Order::count();
        $revenue = Order::where('status', 'delivered')->sum('product_price');
        $recentOrders = Order::orderBy('id', 'DESC')->take(5)->get();
        $recentBuyers = User::role('buyer')->orderBy('id', 'DESC')->take(5)->get();
        $recentSellers = User::role('influencer')->orderBy('id', 'DESC')->take(5)->get();
        return view('admin.index', compact('users', 'seller', 'order', 'revenue', 'recentOrders', 'recentBuyers', 'recentSellers'));
    }

    public function profile(Request $request)
    {
        $admin = Admin::where('email', 'admin@gmail.com')->first();
        return view('admin.profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        DB::beginTransaction();
        
        try {

            $request['password'] = Hash::make($request->confirm_password);           
            if ($request->file('user_image')) {
                $image = $request->file('user_image');
                $imagename = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/user');
                $image->move($destinationPath, $imagename);
                $request['image'] = $imagename;
                Admin::where('id', $request->id)->update($request->except('_token', 'confirm_password', 'user_image'));
            } else {
                Admin::where('id', $request->id)->update($request->except('_token', 'password', 'confirm_password', 'user_image'));
            }            
            
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Profile has been updated!',
            ]);

        } catch (\Exception $e) {
            $message['message'] = $e->getMessage();
            DB::rollback();
            $message['erro'] = 101;
            return response()->json($message, 200);
        } 
    }
}