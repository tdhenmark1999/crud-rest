<?php 

namespace App\Laravel\Transformers;

use Input;
use JWTAuth, Carbon, Helper,Str;
use App\Laravel\Models\Article;
use App\Laravel\Models\User;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use League\Fractal\TransformerAbstract;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Laravel\Transformers\MasterTransformer;



class ArticleTransformer extends TransformerAbstract{

	protected $availableIncludes = [
        'info','author','stat'
    ];


	public function transform(Article $article) {

	    return [
	     	'id' => $article->id ?:0,
	     	'user_id' => $article->user_id,
	     	'title' => Str::title($article->title),
	     	'content' => $article->content,
	     	'video_url' => $article->video_url,
	     	'video_source' => $article->video_source,
	     	'category_id'	=> $article->category_id,
	     	'category_name' => $article->category?$article->category->name:"Unknown",
			'thumbnail' => [
				'path' => $article->directory,
	 			'filename' => $article->filename,
	 			'path' => $article->path,
	 			'directory' => $article->directory,
	 			'full_path' => "{$article->directory}/resized/{$article->filename}",
	 			'thumb_path' => "{$article->directory}/thumbnails/{$article->filename}",
			],
			'date_created' => [
				'date_db' => $article->date_db($article->created_at,env("MASTER_DB_DRIVER","mysql")),
				'month_year' => $article->month_year($article->created_at),
				'time_passed' => $article->time_passed($article->created_at),
				'timestamp' => $article->created_at
			],
	     ];
	}

	public function includeInfo(Article $article) {
		$collection = Collection::make([
			'date_created' => [
				'date_db' => $article->date_db($article->created_at,env("MASTER_DB_DRIVER","mysql")),
				'month_year' => $article->month_year($article->created_at),
				'time_passed' => $article->time_passed($article->created_at),
				'timestamp' => $article->created_at
			],
			
		]);
		return $this->item($collection, new MasterTransformer);
	}

	public function includeStat(Article $article) {
		// dd(Input::user());
		$user = Input::user();

		if($article->reaction->count() > 1){
			$reaction = $article->last_reaction." and ".Helper::format_num($article->reaction->count()-1)." ".Str::plural("like",$article->reaction->count())." this";
		}else{
			$reaction = Helper::format_num($article->reaction->count())." ".Str::plural("like",$article->reaction->count());
		}

		$collection = Collection::make([
			'num_comment' => $article->comment->count(),
			'num_reaction' => $article->reaction->count(),
			'is_like'	=> $article->reaction->where('user_id',$user->id)->where('is_active','yes')->count()?true:false,
			'comment_display'	=> Helper::format_num($article->comment->count())." ".Str::plural("Comment",$article->comment->count()),
			'reaction_display'	=> $reaction,
		]);
		return $this->item($collection, new MasterTransformer);
	}

	public function includeAuthor(Article $article){
       $user = $article->author ? : new User;
       if(is_null($user->id)){ $user->id = 0;}
       return $this->item($user, new UserTransformer);
	}
}