<?php

namespace App\Laravel\Requests\System;

use App\Laravel\Requests\RequestManager;
// use JWTAuth;

class PageRequest extends RequestManager
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->user();
        $id = $this->route('id') ?: 0;
        
        $rules = [
            'title' => "required",
            'description' => "required",
            'type' => 'required',
        ];

        return $rules;
    }

    public function messages() {

        return [
            'required'  => "Field is required.",
            'file.max'  => "Image should not be exceeding to 5mb.",
            
        ];
    }
}
