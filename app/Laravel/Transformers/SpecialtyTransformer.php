<?php 

namespace App\Laravel\Transformers;

use Input,Str;
use JWTAuth, Carbon, Helper;
use App\Laravel\Models\Specialty;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use League\Fractal\TransformerAbstract;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Laravel\Transformers\MasterTransformer;

class SpecialtyTransformer extends TransformerAbstract{

	protected $availableIncludes = [
    ];


	public function transform(Specialty $specialty) {
		$specialty_id = explode(",",Input::get('specialty_id','0'));

	    return [
	     	'id' => $specialty->id ?:0,
	     	'specialty' => $specialty->name,
	     	'is_selected' => in_array($specialty->id,$specialty_id) ? true : false
	     ];
	}
}