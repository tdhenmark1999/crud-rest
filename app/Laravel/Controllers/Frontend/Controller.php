<?php 

namespace App\Laravel\Controllers\Frontend;

use App\Laravel\Models\Support;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller as MainController;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Authenticated;
use Auth, Session,Carbon, Helper,Route, Request;

use Jenssegers\Agent\Agent;

class Controller extends MainController{

	protected $data;

	public function __construct(){
		// self::set_system_routes();
		// self::set_user_info();
		self::set_date_today();
		self::set_current_route();

		// self::set_user_agent();
		// self::set_requests();
		// dd(Request::ip());
	}

	public function get_data(){
		return $this->data;
	}

	public function set_system_routes(){

	}

	public function set_current_route(){
		 $this->data['current_route'] = Route::currentRouteName();
	}

	public function set_user_info(){
		// Event::listen(Authenticated::class, function ($event) {
  //          $this->data['auth'] = $event->user;
  //       });
	}

	public function set_date_today(){
		$this->data['date_today'] = Helper::date_db(Carbon::now());
	}
}