<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\PagesDataTable;
use App\Models\Page;
use Validator;
use Auth;
use DB;

class AdminPageController extends Controller
{
    public function index(PagesDataTable $dataTable, Request $request)
    {        
        return $dataTable->with('filter', $request->all())->render('admin.page.index'); 
    }

    public function create(Request $request)
    {
        return view('admin.page.create');
    }

    public function edit(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        return view('admin.page.create', compact('page'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        try {

            $request['slug'] = str_replace(' ', '-', strtolower($request->title));
            Page::updateOrCreate(['id' => $request->id], $request->all());
            
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Page has been added!',
            ]);

        } catch (\Exception $e) {
            $message['message'] = $e->getMessage();
            DB::rollback();
            $message['erro'] = 101;
            return response()->json($message, 200);
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        
        try {

            Page::where('id', $request->id)->delete();
            
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Page has been Deleted!',
            ]);

        } catch (\Exception $e) {
            $message['message'] = $e->getMessage();
            DB::rollback();
            $message['erro'] = 101;
            return response()->json($message, 200);
        }
    }
}