<?php 

namespace App\Laravel\Controllers\Generic;

/*
*
* Models used for this controller
*/
use App\Laravel\Models\EmailVerification;
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

class VerifyAccountController extends Controller{

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

	public function verify_email($token = NULL){
		$token = Str::lower($token);
		$email_verification = EmailVerification::whereRaw("LOWER(token) = '{$token}'")->first();

		if(!$email_verification){
			session()->flash('notification-status',"failed");
			session()->flash('notification-msg',"Email verification already expired or not found.");
			session()->flash('general-msg',"VERIFICATION REQUEST EXPIRED.");
			goto callback;
		}

		$user = User::where('email', $email_verification->email)->first();

		if($user->is_verified == "yes"){
			session()->flash('notification-status',"failed");
			session()->flash('notification-msg',"Account already verified. No more action is needed.");
			session()->flash('general-msg',"ACCOUNT ALREADY VERIFIED.");
			goto callback;
		}

		$user->is_verified = 'yes';
		$user->save();

		EmailVerification::where('token', $token)->delete();

		session()->flash('notification-status',"success");
		session()->flash('notification-msg',"Account email successfully verified. Thank you for verifying your account.");
		session()->flash('general-msg',"ACCOUNT VERIFIED.");

		callback:
		return view('generic.confirmation',$this->data);
	}


}