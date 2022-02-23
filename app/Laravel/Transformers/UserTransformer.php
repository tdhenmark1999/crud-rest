<?php 

namespace App\Laravel\Transformers;

use Input;
use JWTAuth, Carbon, Helper;
use App\Laravel\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use League\Fractal\TransformerAbstract;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Laravel\Transformers\MasterTransformer;

use Str;

class UserTransformer extends TransformerAbstract{

	protected $user,$auth;

	protected $availableIncludes = [
        'info', 'statistics',
    ];

    public function __construct() {
    	$this->auth = Auth::user();
    }

	public function transform(User $user) {
		$this->user = $user;
	    return [
	     	'id' => $user->id ?:0,
	     	'name' => $user->name,
	     	'username' => $user->username,
	     	'type' => $user->type,
	     	'specialty_id' => $user->specialty_id,
	     	'specialty' => $user->specialty?$user->specialty->name:"n/a",

			'email' => $user->email,
			'description' => $user->description,

			'is_verified' => $user->is_verified,
			'address1' => $user->address1,
			'address2' => $user->address2,
			'city' => $user->city,
			'state' => $user->state,
			'country_iso' => $user->country_iso,
			'country_code' => $user->country_code,
			'contact_number' => $user->contact_number,
			'full_contact_number' => $user->country_code.$user->contact_number,

	     ];
	}

	public function includeInfo(User $user) {
		if($user->filename){
			$full_path = "{$user->directory}/resized/{$user->filename}";
			$thumb_path = "{$user->directory}/thumbnails/{$user->filename}";
		}else{
			$full_path = $thumb_path = asset('placeholder/user.jpg');
		}

		$collection = Collection::make([
			'member_since' => [
				'date_db' => $user->date_db($user->created_at,env("MASTER_DB_DRIVER","mysql")),
				'month_year' => $user->month_year($user->created_at),
				'time_passed' => $user->time_passed($user->created_at),
				'timestamp' => $user->created_at
			],
			'last_activity' => [
				'date_db' => $user->date_db($user->last_activity,env("MASTER_DB_DRIVER","mysql")),
				'month_year' => $user->month_year($user->last_activity),
				'time_passed' => $user->time_passed($user->last_activity),
				'timestamp' => $user->last_activity
			],
	     	'last_login' => [
				'date_db' => $user->date_db($user->last_login,env("MASTER_DB_DRIVER","mysql")),
				'month_year' => $user->month_year($user->last_login),
				'time_passed' => $user->time_passed($user->last_login),
				'timestamp' => $user->last_login
			],
			'avatar' => [
				'path' => $user->directory,
	 			'filename' => $user->filename,
	 			'path' => $user->path,
	 			'directory' => $user->directory,
	 			'full_path' => $full_path,
	 			'thumb_path' => $thumb_path,
			],
		]);
		return $this->item($collection, new MasterTransformer);
	}
}