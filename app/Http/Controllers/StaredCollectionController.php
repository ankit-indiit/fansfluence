<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\InfluencerService;
use App\Http\Services\StaredService;
use App\Models\User;
use App\Models\StarCollection;
use App\Models\StaredInfluencer;
use Auth;

class StaredCollectionController extends Controller
{
    public function index()
    {        
        $collections = StarCollection::where('user_id', Auth::id())->get();
        return view('module.user.stared-collection', compact('collections'));
    }

    public function show(Request $request, $slug)
    {
        $collection = StarCollection::where('user_id', Auth::id())
            ->where('slug', $slug)
            ->first();           
        return view('module.user.stared-influencer', compact('collection'));
    }

    public function store(Request $request, StaredService $staredService, InfluencerService $influencerService)
    {
        if (isset($request->createCollection)) {
            return $staredService->createCollection($request);
        }

        if (isset($request->addToCollection)) {
            return $influencerService->star($request);
        }
    }

    public function destroy(Request $request)
    {
        StarCollection::where('id', $request->collId)
            ->delete();
        return response()->json([
            'status' => true,
            'message' => 'Collection has been Deleted!'
        ]);
    }   

    public function unStarInfluencer(Request $request, InfluencerService $influencerService)
    {
        return $influencerService->unStar($request);        
    }
}
