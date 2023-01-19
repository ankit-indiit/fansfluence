<?php

namespace App\Http\Services;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\StarCollection;
use App\Models\StaredInfluencer;
use DB;
use Auth;

class StaredService
{
	public function createCollection(Request $request)
    {    	
    	DB::beginTransaction();
        
        try {

        	if (StarCollection::where('user_id', Auth::id())
            	->where('name', $request->name)->exists()) {
        		return response()->json([
		            'status' => false,
		            'message' => 'Collection name already exist Please try to another name!'
		        ]); 
        	}

        	if ($request->hasFile('image_name')) {
	            $image = $request->file('image_name');
	            $imagename = time() . '.' . $image->getClientOriginalExtension();
	            $destinationPath = public_path('/collection');
	            $image->move($destinationPath, $imagename);
	            $request['image'] = $imagename;	            
	        }
	        $request['user_id'] = Auth::id();
	        $request['slug'] = str_replace(" ", "-", strtolower($request->name));

		    $collection = StarCollection::create($request->all());
		    if (isset($request->influencer_id)) {
			    StaredInfluencer::create([
			    	'collection_id' => $collection->id,
			    	'influencer_id' => $request->influencer_id
			    ]);		    	
		    }

			DB::commit();

		    return response()->json([
	            'status' => true,
	            'message' => 'Collection has been created!'
	        ]); 

		} catch (\Exception $e) {
            $message['message'] = $e->getMessage();
            DB::rollback();
            $message['erro'] = 101;
            return response()->json($message, 200);
        }
    }

    public function notification($review)
    {

    }
}
