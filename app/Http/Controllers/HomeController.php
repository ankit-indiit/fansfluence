<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Genres;
use App\Models\UserGenres;
use App\Models\Review;
use App\Models\StaredInfluencer;
use Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('module.index');
    }

    public function privacyPolicy()
    {
        return view('module.privacy');
    }

    public function terms()
    {
        return view('module.terms');
    }

    public function guideline()
    {
        return view('module.guideline');
    }
}
