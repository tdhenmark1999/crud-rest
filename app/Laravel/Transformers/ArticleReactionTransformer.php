<?php 

namespace App\Laravel\Transformers;

use Input;
use JWTAuth, Carbon, Helper;
use App\Laravel\Models\ArticleReaction as Reaction;
use App\Laravel\Models\Article;
use App\Laravel\Models\User;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use League\Fractal\TransformerAbstract;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Laravel\Transformers\MasterTransformer;

use Str;

class ArticleReactionTransformer extends TransformerAbstract{

	protected $availableIncludes = [
		'author','article'
    ];


	public function transform(Reaction $reaction) {
	    return [
	     	'id' => $reaction->id ?:0,
	     	'user_id' => $reaction->user_id,
	     	'article_id' => $reaction->article_id,
	     	'type' => $reaction->type,
	     	'is_active' => $reaction->is_active == "yes" ? true : false,
	     	'date_created' => [
	     		'date_db' => $reaction->date_db($reaction->created_at,env("MASTER_DB_DRIVER","mysql")),
	     		'month_year' => $reaction->month_year($reaction->created_at),
	     		'time_passed' => $reaction->time_passed($reaction->created_at),
	     		'timestamp' => $reaction->created_at
	     	],
	     ];
	}

	public function includeAuthor(Reaction $reaction){
       $user = $reaction->author ? : new User;
       if(is_null($user->id)){ $user->id = 0;}
       return $this->item($user, new UserTransformer);
	}

	public function includeArticle(Reaction $reaction){
       $article = $reaction->article ? : new User;
       if(is_null($article->id)){ $article->id = 0;}
       return $this->item($article, new ArticleTransformer);
	}
}