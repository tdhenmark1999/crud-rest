<?php 

namespace App\Laravel\Controllers\System;

/**
*
* Models used for this controller
*/
use App\Laravel\Models\News;

/**
*
* Requests used for validating inputs
*/
use App\Laravel\Requests\System\NewsRequest;

/**
*
* Classes used for this controller
*/
use Helper, Carbon, Session, Str,ImageUploader;

class NewsController extends Controller{

	/**
	*
	* @var Array $data
	*/
	protected $data;

	public function __construct () {
		$this->data = [];
		parent::__construct();
		array_merge($this->data, parent::get_data());
		$this->data['statuses'] = [ 'active' => "Active","inactive" => "Inactive"];
		//$this->data['categories'] = ['--Choose Category--'] + Category::pluck('name','id')->toArray();
		$this->data['heading'] = "News";
	}

	public function index () {
		$this->data['page_title'] = " :: News - Record Data";
		$this->data['news'] = News::orderBy('updated_at',"DESC")->paginate(15);
		return view('system.news.index',$this->data);
	}
	

	public function create () {
		$this->data['page_title'] = " :: News - Add new record";
		return view('system.news.create',$this->data);
	}

	public function store (NewsRequest $request) {
		try {
			$new_news = new News;
			$user = $request->user();
        	$new_news->fill($request->only('title','linked_url','content'));
			
			// $new_news->status = $request->get('status');
			$new_news->user_id = $request->user()->id;
			if($new_news->save()) {
				session()->flash('notification-status','success');
				session()->flash('notification-msg',"New record has been added.");
				return redirect()->route('system.news.index');
			}
			session()->flash('notification-status','failed');
			session()->flash('notification-msg','Something went wrong.');

			return redirect()->back();
		} catch (Exception $e) {
			session()->flash('notification-status','failed');
			session()->flash('notification-msg',$e->getMessage());
			return redirect()->back();
		}
	}

	public function edit ($id = NULL) {
		$this->data['page_title'] = " :: News - Edit record";
		$news = News::find($id);

		if (!$news) {
			session()->flash('notification-status',"failed");
			session()->flash('notification-msg',"Record not found.");
			return redirect()->route('system.news.index');
		}

		if($id < 0){
			session()->flash('notification-status',"warning");
			session()->flash('notification-msg',"Unable to update special record.");
			return redirect()->route('system.news.index');	
		}

		$this->data['news'] = $news;
		return view('system.news.edit',$this->data);
	}

	public function update (NewsRequest $request, $id = NULL) {
		try {
			$news = News::find($id);

			if (!$news) {
				session()->flash('notification-status',"failed");
				session()->flash('notification-msg',"Record not found.");
				return redirect()->route('system.news.index');
			}

			if($id < 0){
				session()->flash('notification-status',"warning");
				session()->flash('notification-msg',"Unable to update special record.");
				return redirect()->route('system.news.index');	
			}
			$user = $request->user();
        	$news->fill($request->only('title','linked_url','content'));
        	if($request->hasFile('file')) {
        	    $image = ImageUploader::upload($request->file('file'), "uploads/images/users/{$user->id}/news");
        	    $news->path = $image['path'];
        	    $news->directory = $image['directory'];
        	    $news->filename = $image['filename'];
        	}

			if($news->save()) {
				session()->flash('notification-status','success');
				session()->flash('notification-msg',"Record has been modified successfully.");
				return redirect()->route('system.news.index');
			}

			session()->flash('notification-status','failed');
			session()->flash('notification-msg','Something went wrong.');

		} catch (Exception $e) {
			session()->flash('notification-status','failed');
			session()->flash('notification-msg',$e->getMessage());
			return redirect()->back();
		}
	}

	public function destroy ($id = NULL) {
		try {
			$news = News::find($id);

			if (!$news) {
				session()->flash('notification-status',"failed");
				session()->flash('notification-msg',"Record not found.");
				return redirect()->route('system.news.index');
			}

			if($id < 0){
				session()->flash('notification-status',"warning");
				session()->flash('notification-msg',"Unable to remove special record.");
				return redirect()->route('system.news.index');	
			}

			if($news->delete()) {
				session()->flash('notification-status','success');
				session()->flash('notification-msg',"Record has been deleted.");
				return redirect()->route('system.news.index');
			}

			session()->flash('notification-status','failed');
			session()->flash('notification-msg','Something went wrong.');

		} catch (Exception $e) {
			session()->flash('notification-status','failed');
			session()->flash('notification-msg',$e->getMessage());
			return redirect()->back();
		}
	}

}