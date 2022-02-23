<?php namespace App\Laravel\Requests\Frontend;

use Session,Auth;
use App\Laravel\Requests\RequestManager;

class InquiryRequest extends RequestManager{

	public function rules(){

		$rules = [
			'name' => "required",
			'email' => "required|email",
			'subject' => "required",
			'message' => "required",
		];

		return $rules;
	}

	public function messages(){
		return [
			'required' => "This field is required.",
		];
	}

	public function response(array $errors)
	{
		if ($this->ajax() || $this->wantsJson())
		{
			return response()->json($errors, 422);
		}

		Session::flash('notification-status','failed');
		Session::flash('notification-msg','Some fields are not accepted.');

		return $this->redirector->to($this->getRedirectUrl())
		->withInput($this->except($this->dontFlash))
		->withErrors($errors, $this->errorBag);
	}
}