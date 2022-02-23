<?php 

namespace App\Laravel\Transformers;

use Input;
use JWTAuth, Carbon, Helper;
use App\Laravel\Models\UserWallet;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use League\Fractal\TransformerAbstract;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Laravel\Transformers\MasterTransformer;

use Str;

class UserWalletTransformer extends TransformerAbstract{

	protected $user;

	protected $availableIncludes = [
    ];

    public function __construct() {
    	$this->user = Auth::user();
    }

	public function transform(UserWallet $wallet) {
		$cur_symbol = $this->user->legal_currency?$this->user->legal_currency->symbol: "$";
	    return [
	     	// 'id' => $currency->id ?:0,
	     	'code' => $wallet->code,
			'credit' => (string)Helper::amount($wallet->credit*($wallet->crypto?($wallet->crypto->price*$wallet->credit):0)),
			'credit_balance' => "{$cur_symbol} ".Helper::amount($wallet->crypto?($wallet->crypto->price*$wallet->credit):0),
			'price'	=>	"{$cur_symbol} ".Helper::amount($wallet->crypto?$wallet->crypto->price:0),
			'actual_price'	=> (string)Helper::amount($wallet->crypto?$wallet->crypto->price:0,""),
			'rate'	=> (string) Helper::crypto_amount($wallet->crypto?$wallet->crypto->rate:0),
			'margin' => (string) ($wallet->crypto?$wallet->crypto->margin:0),

	     ];
	}

}