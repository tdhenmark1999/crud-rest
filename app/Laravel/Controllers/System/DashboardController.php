<?php 

namespace App\Laravel\Controllers\System;

/*
*
* Models used for this controller
*/
use App\Laravel\Models\User;
use App\Laravel\Models\Registration;


/*
*
* Requests used for validating inputs
*/


/*
*
* Classes used for this controller
*/
use Helper, Carbon, Session, Str, DB;

class DashboardController extends Controller{

	/*
	*
	* @var Array $data
	*/
	protected $data;

	public function __construct () {
		$this->data = [];
		parent::__construct();
		array_merge($this->data, parent::get_data());
	}

	public function index(){
		$this->data['page_title'] = " :: Dashboard & Statistics";
		$datenow = Carbon::now();
/*
		$this->data['total_registered'] = Registration::count();
		$this->data['total_male'] = Registration::where('gender','male')->count();
		$this->data['total_female'] = Registration::where('gender','female')->count();
		$total_profile = Registration::select('*')->selectRaw('count(*) as total')->groupby('profile')
			 	->orderBy('total' , 'DESC')->paginate(15);

		$total_other_profile = Registration::select('*')->selectRaw('count(*) as total')->groupby('other_profile')
			 	->orderBy('total' , 'DESC')->paginate(15);

		$total_ads = Registration::select('*')->selectRaw('count(*) as total')->groupby('ads')
			 	->orderBy('total' , 'DESC')->get();

		$total_region = Registration::select('*')->selectRaw('count(*) as total')->groupby('region')
			 	->orderBy('total' , 'DESC')->paginate(10);

	    $total_province = Registration::select('*')->selectRaw('count(*) as total')->groupby('province')
			 	->orderBy('total' , 'DESC')->paginate(10);
		$total_city = Registration::select('*')->selectRaw('count(*) as total')->groupby('city')
			 	->orderBy('total' , 'DESC')->paginate(10);

		$total_location = Registration::select('*')->selectRaw('count(*) as total')->groupby('event_location')
			 	->orderBy('total' , 'DESC')->get();

		$this->data['total_profile'] = $total_profile;
		$this->data['total_location'] = $total_location;
		$this->data['total_city'] = $total_city;
		$this->data['total_region'] = $total_region;
		$this->data['total_province'] = $total_province;
		$this->data['total_ads'] = $total_ads;
		$this->data['total_other_profile'] = $total_other_profile;*/
		return view('system.index',$this->data);
	}
}