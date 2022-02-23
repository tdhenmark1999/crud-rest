<?php namespace App\Laravel\Requests\Frontend;

use Session,Auth;
use App\Laravel\Requests\RequestManager;

class SubscribeRequest extends RequestManager{

	public function rules(){

		// $id = $this->route('id')?:0;
		// $id = Auth::user()->id;

		$rules = [
			// 'username'		=> "required|unique:user,username,{$id}",
			// 'email'	=> "required|unique:user,email,{$id}",
			// 'description'	=> "required",
			'email'		=> "required|email|is_subscribe:email",
			'contact_number'		=> "required|phone:PH|is_subscribe:contact_number",

		];

		return $rules;
	}

	public function messages(){
		return [
			'required'	=> "Field is required.",
			'email.required'		=> "Please indicate your email address",
			'email.email'	=> "Invalid email address format.",
			'contact_number.required'	=> "Please indicate your contact number.",
			'contact_number.phone'	=> "Invalid Philippines contact number format.",
			'email.is_subscribe'	=> "Email address already on our list.",
			'contact_number.is_subscribe'	=> "Contact number already on our list.",
		];
	}

	
}