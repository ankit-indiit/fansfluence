<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\DataTables\ContactUsDataTable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ContactUs;
use DataTables;
use Validator;
use Auth;
use DB;

class AdminContactUsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ContactUs::query();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('name', static function (ContactUs $contactUs) {
                    return $contactUs->name;
                })->filterColumn('name', function ($query, $keyword) {
                   $query->whereRaw("name like ?", ["%$keyword%"]);
                })
              
                ->editColumn('email', static function (ContactUs $contactUs) {
                    return $contactUs->email;
                })

                ->editColumn('reason', static function (ContactUs $contactUs) {
                    if ($contactUs->reaching_out_us == 'reason-issue') {
                        return 'I have an issue';
                    }
                                                                
                    if ($contactUs->reaching_out_us == 'reason-question') {
                        return 'I have a question';
                    }
                })

                ->editColumn('date', static function (ContactUs $contactUs) {
                    return $contactUs->created_at;
                })

                ->editColumn('action', static function (ContactUs $contactUs) {
                    return '<a href="#" class="btn btn-sm bg-info-light contactDesc" data-id="'.$contactUs->id.'" data-toggle="modal" data-target="#contactUsMessage"><i class="far fa-eye mr-1"></i></a>';
                })  
                ->setRowId(function ($contactUs) {
                    return 'contact-'.$contactUs->id;
                })
                ->rawColumns(['action'])->make(true);
        }
        return view('admin.contact-us.index');
        // return $dataTable->with('filter', $request->all())->render('admin.contact-us.index');        
    }

    public function show(Request $request)
    {
        $desc = ContactUs::where('id', $request->id)->pluck('question_description')->first();
        return response()->json([
            'status' => true,
            'data' => $desc,
        ]);
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        
        try {

            if (ContactUs::where('id', $request->id)
                ->delete()) {
                $status = true;
                $message = 'Contact Us has been Deleted!';
            } else {
                $status = false;
                $message = 'Please try again!';
            }
            
        DB::commit();

        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);

        } catch (\Exception $e) {
            $message['message'] = $e->getMessage();
            DB::rollback();
            $message['erro'] = 101;
            return response()->json($message, 200);
        }
    }
}