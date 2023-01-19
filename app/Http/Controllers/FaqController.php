<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FaqTitle;
use App\Models\FaqQues;

class FaqController extends Controller
{
    public function index(Request $request)
    {
    	$buyerFaqs = FaqQues::where('user', 'buyer')->get();
        $influencerFaqs = FaqQues::where('user', 'influencer')->get();       
    	return view('module.faq', compact('buyerFaqs', 'influencerFaqs'));
    }

    public function show(Request $request)
    {
        $faqs = FaqQues::where('question', 'like', '%' . $request->faq  . '%')
            ->get();        

        $data = '';
        foreach ($faqs as $faq) {
            $qus = '';
            foreach ($faq->faq as $ques) {
                $qus .= '<li class="list-group-item">'.$ques->answer.'</li>';
            }
            $data .= '<div class="faq-accordian accordion" id="'.$faq->id.'Example"> <div class="accordion-item"> <h2 class="accordion-header" id="heading'.$faq->id.'"> <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse'.$faq->id.'" aria-expanded="false" aria-controls="collapse{{$faq->id}}"> <span><img src="'.asset('assets/img/faq-icon.svg').'" class="img-fluid"></span> '.$faq->question.'</button> </h2> <div id="collapse'.$faq->id.'" class="accordion-collapse collapse" aria-labelledby="heading'.$faq->id.'" data-bs-parent="#'.$faq->id.'Example"> <div class="accordion-body"> <ol class="list-group list-group-numbered"> '.$qus.'</ol> </div> </div> </div> </div>'; 
        }
        return response()->json([
            'status' => true,
            'faqs' => $data
        ]);
    }
}
