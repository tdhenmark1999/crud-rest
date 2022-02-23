<?php

namespace App\Laravel\Requests\Generic;

use App\Laravel\Requests\RequestManager;

class ResetPasswordRequest extends RequestManager
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            'password' => "required|confirmed",
            // 'validation_token' => "required",
        ];

        return $rules;
    }

    public function messages() {

        return [
           'required'   => "Field is required.",
           'password.confirmed'   => "Password mismatch."
        ];
    }

    public function response(array $errors)
    {
        if ($this->expectsJson()) {
            return response()->json($errors, 422);
        }

        session()->flash('notification-status','error');
        session()->flash('notification-msg','Password mismatch. Please double check your input.');

        return $this->redirector->to($this->getRedirectUrl())
                                        ->withInput($this->except($this->dontFlash))
                                        ->withErrors($errors, $this->errorBag);
    }
}
