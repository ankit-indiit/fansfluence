<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use DataTables;
use Validator;
use Session;
use DB;

class AdminCategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::query();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('name', static function (Category $category) {
                    return $category->name;
                })
                ->editColumn('sub_category', static function (Category $category) {
                    $subCategories = SubCategory::where('category_id', $category->id)->pluck('name');
                    $str = '';
                    foreach($subCategories as $subCategory) {
                        $str .= '<span class="badge badge-primary">'.$subCategory.'</span> ';                    
                    }
                    return $str;
                })
                ->editColumn('action', static function (Category $category) {
                    return '<a href="'.route('category.edit', $category->id).'" class="btn btn-sm bg-info-light"><i class="far fa-edit mr-1"></i></a><a href="#" class="btn btn-sm bg-danger-light" id="deleteCategory" data-id="'.$category->id.'"><i class="fa fa-trash"></i></a>';
                })  
                ->setRowId(function ($category) {
                    return 'contact-'.$category->id;
                })
                ->rawColumns(['sub_category', 'action'])->make(true);
        }
        return view('admin.category.index');      
    }    

    public function create(Request $request)
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        try {

            $category = Category::create([
                'name' => $request->name
            ]);
            foreach ($request->sub_categories as $subCategory) {
                SubCategory::create([
                    'category_id' => $category->id,
                    'name' => $subCategory,
                ]);
            }            
            
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Category created successfully!',
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
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {        
        DB::beginTransaction();
        
        try {

            Category::where('id', $id)->update([
                'name' => $request->name
            ]);
            if (count($request->sub_categories) > 0) {
                SubCategory::where('category_id', $id)->delete();
                foreach ($request->sub_categories as $subCategory) {
                    SubCategory::create([
                        'category_id' => $id,
                        'name' => $subCategory,
                    ]);
                }                            
            }
            
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Category updated successfully!',
            ]);
            
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

    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        
        try {

            Category::findOrFail($id)->delete();
            SubCategory::where('category_id', $id)->delete();
            
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Category deleted successfully!',
            ]);

        } catch (\Exception $e) {
            $message['message'] = $e->getMessage();
            DB::rollback();
            $message['erro'] = 101;
            return response()->json($message, 200);
        }
    }
}