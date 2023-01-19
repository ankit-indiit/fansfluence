<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\ContactUsService;
use App\Http\Requests\ContactUsRequest;
use App\Models\Genres;
use App\Models\UserGenres;

class ContactUsController extends Controller
{
    public function index(Request $request)
    {
    	$genreses = Genres::all();
    	return view('module.contact-us', compact('genreses'));
    }

    public function store(ContactUsRequest $request, ContactUsService $contactUsService)
    {    	
    	$contactUs = $contactUsService->createContactUs($request);
    	return response()->json([
    		'status' => true,
    		'message' => 'Form has been submitted!'
    	]);
    }
}
