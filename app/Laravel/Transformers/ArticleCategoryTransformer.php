<?php 

namespace App\Laravel\Transformers;

use Input,Str;
use JWTAuth, Carbon, Helper;
use App\Laravel\Models\ArticleCategory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use League\Fractal\TransformerAbstract;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Laravel\Transformers\MasterTransformer;

class ArticleCategoryTransformer extends TransformerAbstract{

	protected $availableIncludes = [
    ];


	public function transform(ArticleCategory $category) {
		$category_id = explode(",",Input::get('category_id','0'));

	    return [
	     	'id' => $category->id ?:0,
	     	'category_name' => $category->name,
	     	'is_selected' => in_array($category->id,$category_id) ? true : false
	     ];
	}
}