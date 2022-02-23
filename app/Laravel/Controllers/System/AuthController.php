<?php 

namespace App\Laravel\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Laravel\Models\User as Account;
use App\Laravel\Requests\System\RegisterRequest;

use Session, Input, Auth,Carbon,Helper;

class AuthController extends Controller{

	protected $data;

	public function __construct(Guard $auth){
		$this->auth = $auth;
	}

	public function login($redirect_uri = NULL){
		$this->data['page_title'] = " :: Login";
		// $data['page_class'] = "login-body";
		return view('system.auth.login',$this->data);
	}

	public function register($_token = NULL){
		if($_token){
			$_token = base64_decode($_token);
			$this->data['page_title'] = " :: Register";
			if(Helper::date_db(Carbon::now()) <= $_token){
				return view('system.auth.register',$this->data);
			}
		}

		session()->flash('notification-status','failed');
		session()->flash('notification-msg','Unauthorized access.');
		return redirect()->route('system.login');
	}


	public function authenticate($redirect_uri = NULL){
		try{
			$this->data['page_title'] = " :: Login";
			$username = Input::get('username');
			$password = Input::get('password');
			$remember_me = Input::get('remember_me',0);
			$field = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';	

			if($this->auth->attempt([$field => $username,'password' => $password], $remember_me)){
				session()->flash('notification-status','success');
				session()->flash('notification-title',"It's nice to be back");
				session()->flash('notification-msg',"Welcome {$this->auth->user()->name}!");
				$this->auth->user()->save();
				if($redirect_uri AND session()->has($redirect_uri)){
					return redirect( session()->get($redirect_uri) );
				}

				return redirect()->route('system.dashboard');
			}	

			session()->flash('notification-status','failed');
			session()->flash('notification-msg','Wrong username or password.');
			return redirect()->back();

		}catch(Exception $e){
			abort(500);
		}
	}

	public function destroy(){
		$this->auth->logout();
		session()->flash('notification-status','success');
		session()->flash('notification-msg','You are now signed off.');
		return redirect()->route('system.login');
	}

	public function lock() {
	  $this->data['page_title'] = ":: System Lock";
	  $user = $this->auth->user();

	  if($user->is_lock == "no"){
	  	if(Input::has('redirect') AND Input::get('redirect') == "yes"){
  		  	session()->flash('notification-status','failed');
  			session()->flash('notification-msg','System automatically locked due to inactivity/no response to the system.');
  		}else{
		  	session()->flash('notification-status','success');
			session()->flash('notification-msg','System has been locked. Enter your password to access again.');
  		}
	  	
	  }

	  $user->is_lock = "yes";
	  $user->save();
	  $this->data['auth'] = $user;
	  return view('system.auth.lock',$this->data);
	 }

	public function unlock() {
	  try {
	   $user = $this->auth->user();
	   $password = Input::get('password');
	   $remember_me = Input::get('remember_me',0);

	   if($this->auth->attempt(['username' => $user->username,'password' => $password], $remember_me)){
	    $user->is_lock = "no";
	    $user->save();
	    session()->flash('notification-status','success');
	    session()->flash('notification-title',"It's nice to be back");
	    session()->flash('notification-msg',"Welcome {$this->auth->user()->name}!");
	    return redirect()->intended('/');
	   }

	   session()->flash('notification-status','failed');
	   session()->flash('notification-msg','Invalid password.');
	   return redirect()->back();

	  } catch (Exception $e) {
	   abort(500);
	  }
	 }
}