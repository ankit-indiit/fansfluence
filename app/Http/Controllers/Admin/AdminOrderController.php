<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\DataTables\OrderDataTable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Review;
use Validator;
use DataTables;
use Session;
use Auth;
use DB;

class AdminOrderController extends Controller
{
    public function index(OrderDataTable $dataTable, Request $request)
    {
        if ($request->ajax()) {
            $data = Order::query();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('order_id', static function (Order $order) {
                    return $order->order_id;
                })

                ->editColumn('product', static function (Order $order) {
                    return $order->product .' '. $order->mark;
                })
              
                ->editColumn('status', static function (Order $order) {
                    switch ($order->status) {
                        case 'pending':
                            $tab = 'primary';
                        break;
                        case 'accept':
                            $tab = 'secondary';
                        break;
                        case 'decline':
                            $tab = 'danger';
                        break;
                        case 'completed':
                            $tab = 'success';
                        break;  
                        case 'delivered':
                            $tab = 'info';
                        break;     
                    }
                    return '<span class="badge badge-'.$tab.'">'.ucfirst($order->status).'</span>';
                })

                ->editColumn('user_id', static function (Order $order) {
                    return getUserNameById($order->user_id);
                })

                ->editColumn('created_at', static function (Order $order) {
                    return $order->created_at;
                })

                ->editColumn('action', static function (Order $order) {
                    return '<a href="'.route('order.show', $order->id).'" class="btn btn-sm bg-info-light"><i class="fa fa-eye"></i></a>';
                })                 
               
                ->setRowId(function ($order) {
                    return 'payment-'.$order->id;
                })
                ->rawColumns(['action','status','order_id'])->make(true);
        }
        return view('admin.order.index');
        // return $dataTable->with('filter', $request->all())->render('admin.order.index');         
    }

    public function show(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $review = Review::where('influencer_id', $order->orderDetail->influencer_id)
                ->where('user_id', $order->orderDetail->user_id)
                ->where('order_id', $order->id)
                ->first();       
        return view('admin.order.show', compact('order', 'review'));  
    }

    public function status(Request $request)
    {
        if ( Order::where('id', $request->id)->update(['status' => $request->status]) ) {
            $status = true;
            $message = 'Order status has been updated!';
        } else {
            $status = false;
            $message = 'Please try again!';
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        
        try {

            
        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully!',
        ]);

        } catch (\Exception $e) {
            $message['message'] = $e->getMessage();
            DB::rollback();
            $message['erro'] = 101;
            return response()->json($message, 200);
        }
    }
}