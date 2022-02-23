<?php 

namespace App\Laravel\Controllers\System;

/**
*
* Models used for this controller
*/
use App\Laravel\Models\Article;

/**
*
* Requests used for validating inputs
*/
use App\Laravel\Requests\System\ArticleRequest;

/**
*
* Classes used for this controller
*/
use Helper, Carbon, Session, Str,ImageUploader;

class ArticleController extends Controller{

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
		$this->data['heading'] = "Article";
	}

	public function index () {
		$this->data['page_title'] = " :: Events - Record Data";
		$this->data['articles'] = Article::orderBy('updated_at',"DESC")->paginate(15);
		return view('system.article.index',$this->data);
	}
	

	public function create () {
		$this->data['page_title'] = " :: Events - Add new record";
		return view('system.article.create',$this->data);
	}

	public function store (ArticleRequest $request) {
		try {
			$new_article = new Article;
			$user = $request->user();
        	$new_article->fill($request->only('title','linked_url','content'));
			if($request->hasFile('file')) {
			    $image = ImageUploader::upload($request->file('file'), "uploads/images/users/{$user->id}/articles");
			    $new_article->path = $image['path'];
			    $new_article->directory = $image['directory'];
			    $new_article->filename = $image['filename'];
			}
			// $new_article->status = $request->get('status');
			$new_article->user_id = $request->user()->id;
			if($new_article->save()) {
				session()->flash('notification-status','success');
				session()->flash('notification-msg',"New record has been added.");
				return redirect()->route('system.article.index');
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
		$this->data['page_title'] = " :: Events - Edit record";
		$article = Article::find($id);

		if (!$article) {
			session()->flash('notification-status',"failed");
			session()->flash('notification-msg',"Record not found.");
			return redirect()->route('system.article.index');
		}

		if($id < 0){
			session()->flash('notification-status',"warning");
			session()->flash('notification-msg',"Unable to update special record.");
			return redirect()->route('system.article.index');	
		}

		$this->data['article'] = $article;
		return view('system.article.edit',$this->data);
	}

	public function update (ArticleRequest $request, $id = NULL) {
		try {
			$article = Article::find($id);

			if (!$article) {
				session()->flash('notification-status',"failed");
				session()->flash('notification-msg',"Record not found.");
				return redirect()->route('system.article.index');
			}

			if($id < 0){
				session()->flash('notification-status',"warning");
				session()->flash('notification-msg',"Unable to update special record.");
				return redirect()->route('system.article.index');	
			}
			$user = $request->user();
        	$article->fill($request->only('title','linked_url','content'));
        	if($request->hasFile('file')) {
        	    $image = ImageUploader::upload($request->file('file'), "uploads/images/users/{$user->id}/articles");
        	    $article->path = $image['path'];
        	    $article->directory = $image['directory'];
        	    $article->filename = $image['filename'];
        	}

			if($article->save()) {
				session()->flash('notification-status','success');
				session()->flash('notification-msg',"Record has been modified successfully.");
				return redirect()->route('system.article.index');
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
			$article = Article::find($id);

			if (!$article) {
				session()->flash('notification-status',"failed");
				session()->flash('notification-msg',"Record not found.");
				return redirect()->route('system.article.index');
			}

			if($id < 0){
				session()->flash('notification-status',"warning");
				session()->flash('notification-msg',"Unable to remove special record.");
				return redirect()->route('system.article.index');	
			}

			if($article->delete()) {
				session()->flash('notification-status','success');
				session()->flash('notification-msg',"Record has been deleted.");
				return redirect()->route('system.article.index');
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