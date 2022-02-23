<?php 

namespace App\Laravel\Transformers;

use Input;
use JWTAuth, Carbon, Helper;
use App\Laravel\Models\Waybill;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use League\Fractal\TransformerAbstract;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Laravel\Transformers\MasterTransformer;

use Str;

class WaybillTransformer extends TransformerAbstract{

	protected $user;

	protected $availableIncludes = [
       
    ];

	public function transform(Waybill $waybill) {

	    return [
	     	// 'id' => $currency->id ?:0,
	     	'waybill_id' => $waybill->waybill_id,	
			'is_cod' => $waybill->is_cod,
			'cod_amount'	=> $waybill->cod_amount
	     ];
	}
}