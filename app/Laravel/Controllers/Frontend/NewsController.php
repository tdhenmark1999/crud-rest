<?php

namespace App\Laravel\Controllers\Frontend;
use App\Laravel\Models\News;

use App\Laravel\Requests\System\NewsRequest;

use Helper, Carbon, Session, Str, DB,Input,Event;

class NewsController extends Controller
{	
	protected $data;

	public function __construct () {
		
	}

 
	public function index()
    {
        $this->data = News::orderBy('updated_at',"DESC")->get();
        return response()->json([
            "message" => "Ok",
            "status" => 200,
            'result' => $this->data
        ]);
    }

	public function destroy($id)
    {
        $newss = News::findOrFail($id);
        $newss->destroy($id);
        return response()->json([
            "message" =>  "Data Deleted",
            "status" => 200,
            'data' =>  $newss
        ]);
    }


	public function update(NewsRequest $request, $id)
    {
        $newss = News::find($id);

           if(is_null($newss)) {
               return response()->json([
                   "message" => "Event not found"
               ], 404);
           }else {
            $newss->update($request->all());
            return response()->json([
                "message" => "Event successfully updated",
                "status" => 200,
                'result' =>  $newss
            ]);
            }
    }


	public function create(NewsRequest $request)
    {
        // return $request->all();
       
            $newss = new News;
            $newss->title = $request->title;
            $newss->linked_url = $request->linked_url;
            $newss->content = $request->content;
    
            
            $newss->save();
            
            return response()->json([
                'message' => "News Successfully Added",
                'result' => $newss,
                'status'=>200
            ]);
    }
}
