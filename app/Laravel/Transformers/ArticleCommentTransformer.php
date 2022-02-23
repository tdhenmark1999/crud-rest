<?php 

namespace App\Laravel\Transformers;

use Input;
use JWTAuth, Carbon, Helper;
use App\Laravel\Models\ArticleComment as Comment;
use App\Laravel\Models\Article;
use App\Laravel\Models\User;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use League\Fractal\TransformerAbstract;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Laravel\Transformers\MasterTransformer;

use Str;

class ArticleCommentTransformer extends TransformerAbstract{

	protected $availableIncludes = [
		'author','article'
    ];


	public function transform(Comment $comment) {
	    return [
	     	'id' => $comment->id ?:0,
	     	'content' => $comment->content,
	     	'user_id' => $comment->user_id,
	     	'article_id' => $comment->article_id,
	     	'date_created' => [
	     		'date_db' => $comment->date_db($comment->created_at,env("MASTER_DB_DRIVER","mysql")),
	     		'month_year' => $comment->month_year($comment->created_at),
	     		'time_passed' => $comment->time_passed($comment->created_at),
	     		'timestamp' => $comment->created_at
	     	],
	     ];
	}

	public function includeAuthor(Comment $comment){
       $user = $comment->author ? : new User;
       if(is_null($user->id)){ $user->id = 0;}
       return $this->item($user, new UserTransformer);
	}

	public function includeArticle(Comment $comment){
       $article = $comment->article ? : new User;
       if(is_null($article->id)){ $article->id = 0;}
       return $this->item($article, new ArticleTransformer);
	}
}