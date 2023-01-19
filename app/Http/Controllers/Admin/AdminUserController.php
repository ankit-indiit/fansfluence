<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Validator;
use Session;
use DB;

class AdminUserController extends Controller
{
    public function index(UsersDataTable $dataTable, Request $request)
    {
        return $dataTable->with('filter', $request->all())->render('admin.user.index');        
    }

    public function show(Request $request, $id)
    {
        $user = User::findOrFail($id);       
        return view('admin.user.show', compact('user'));
    }

    public function create(Request $request)
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        try {

            if ($request->hasFile('user_image')) {
                $image = $request->file('user_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/user');
                $image->move($destinationPath, $imageName);
                $request['image'] = $imageName;
            }
            $request['password'] = Hash::make($request->confirm_password);
            $request['email_verified_at'] = now();
            $user = User::create($request->except('user_image', 'confirm_password', 'role'));            
            $user->assignRole($request->role);
            
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'User created successfully!',
            ]);

        } catch (\Exception $e) {
            $message['message'] = $e->getMessage();
            DB::rollback();
            $message['erro'] = 101;
            return response()->json($message, 200);
        }
    }

    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {        
        DB::beginTransaction();
        
        try {

            $user = User::findOrFail($id);
            if ($request->hasFile('user_image')) {
                $image = $request->file('user_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/user');
                $image->move($destinationPath, $imageName);
                $request['image'] = $imageName;
            }
            if (isset($request->confirm_password)) {
                $request['password'] = Hash::make($request->confirm_password);
                $user->update($request->except('user_image', 'confirm_password', 'role'));
            } else {
                $user->update($request->except('user_image', 'password', 'confirm_password', 'role'));
            }
            // $user->assignRole($request->role);
        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'User updated successfully!',
        ]);

        } catch (\Exception $e) {
            $message['message'] = $e->getMessage();
            DB::rollback();
            $message['erro'] = 101;
            return response()->json($message, 200);
        }
    }

    public function status(Request $request)
    {
        if (User::where('id', $request->userId)->update(['status' => $request->status])) {
            $status = true;
            $message = 'Profile status has been updated!';
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

            User::findOrFail($request->id)->delete();
            
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