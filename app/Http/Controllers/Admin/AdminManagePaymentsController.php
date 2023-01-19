<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\DataTables\ManagePaymentsDataTable;
use App\Models\User;
use App\Models\Order;
use Validator;
use Auth;
use DB;

class AdminManagePaymentsController extends Controller
{
    public function index(ManagePaymentsDataTable $dataTable, Request $request)
    {        
        return $dataTable->with('filter', $request->all())->render('admin.manage-payment.index'); 
    }
}