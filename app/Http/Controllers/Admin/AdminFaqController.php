<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\DataTables\FaqDataTable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\FaqTitle;
use App\Models\FaqQues;
use App\Models\FaqAns;
use Validator;
use Auth;
use DB;

class AdminFaqController extends Controller
{
    public function index(FaqDataTable $dataTable, Request $request)
    {
        return $dataTable->with('filter', $request->all())->render('admin.faq.index');
        // $faqs = FaqQues::orderBy('id', 'DESC')
        //     ->get();        
        // return view('admin.faq.index', compact('faqs'));  
    }

    public function create(Request $request)
    {
        return view('admin.faq.create');  
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        try {

            $question = FaqQues::create([
                'user' => $request->user,
                'question' => $request->question,
            ]);            

            if (count($request->answer) > 0) {
                foreach ($request->answer as $ans) {
                    if (isset($ans)) {
                        FaqAns::create([
                            'qus_id' => $question->id,
                            'answer' => $ans,
                        ]);
                    }
                }
            }
            
            DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'FAQ has been added!',
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
        $faq = FaqQues::findOrFail($id);
        $faqAnswers = FaqAns::where('qus_id', $id)->get();
        return view('admin.faq.edit', compact('faq', 'faqAnswers'));  
    }

    public function update(Request $request)
    {        
        DB::beginTransaction();
        
        try {

            FaqQues::where('id', $request->id)->update([
                'user' => $request->user,
                'question' => $request->question,
            ]);

            if (count($request->answer) > 0) {
                FaqAns::where('qus_id', $request->id)->delete();
                foreach ($request->answer as $ans) {
                    if (isset($ans)) {
                        FaqAns::create([
                            'qus_id' => $request->id,
                            'answer' => $ans,
                        ]);
                    }
                }
            }
            
            DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'FAQ has been updated!',
        ]);

        } catch (\Exception $e) {
            $message['message'] = $e->getMessage();
            DB::rollback();
            $message['erro'] = 101;
            return response()->json($message, 200);
        } 
    }

    public function show(Request $request, $id)
    {
        $faq = FaqQues::findOrFail($id);
        $faqAnswers = FaqAns::where('qus_id', $id)->get();
        return view('admin.faq.show', compact('faq', 'faqAnswers'));  
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        
        try {
           
            FaqQues::where('id', $request->id)->delete();
            FaqAns::where('qus_id', $request->id)->delete();
            $status = true;
            $message = 'FAQ has been Deleted!';            

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