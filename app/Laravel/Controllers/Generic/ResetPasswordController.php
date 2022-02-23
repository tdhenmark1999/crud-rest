<?php 

namespace App\Laravel\Controllers\Generic;

/*
*
* Models used for this controller
*/
use App\Laravel\Models\PasswordReset;
use App\Laravel\Models\User;


/*
*
* Requests used for validating inputs
*/
use App\Laravel\Requests\Generic\ResetPasswordRequest;
use App\Laravel\Events\SendEmail;


/*
*
* Classes used for this controller
*/
use Helper, Carbon, Session, Str, DB,Input,Event;

class ResetPasswordController extends Controller{

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

	public function index($token = NULL){
		$token = Str::lower($token);
		$password_reset = PasswordReset::whereRaw("LOWER(token) = '{$token}'")->first();

		if(!$password_reset){
			return view('generic.invalid-token',$this->data);
		}	
		return view('generic.reset-password',$this->data);
	}

	public function submit(ResetPasswordRequest $request, $token = NULL){
		$token = Str::lower($token);
		$password_reset = PasswordReset::whereRaw("LOWER(token) = '{$token}'")->first();
		if(!$password_reset){
			return view('generic.invalid-token',$this->data);
		}


		$user = User::where('email', $password_reset->email)->first();
		$user->password = bcrypt($request->get('password'));
		$user->save();

		PasswordReset::where('token', $token)->delete();

		session()->flash('notification-status',"success");
		session()->flash('notification-msg',"New password successfully stored. Login to the platform using your updated credentials.");
		session()->flash('general-msg',"REQUEST HAS BEEN COMPLETE. NEW PASSWORD HAS BEEN SET");
		return view('generic.confirmation',$this->data);
		
	}

}