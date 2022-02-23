<?php

namespace App\Laravel\Requests\System;

use App\Laravel\Requests\RequestManager;
// use JWTAuth;

class NewsRequest extends RequestManager
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
            'file' => "image|max:5000",
            'title' => "required",
           
           
        ];

        if($id){
            $rules['file'] = "image";
        }

        return $rules;
    }

    public function messages() {

        return [
            'required'  => "Field is required.",
            'file.max'  => "Image should not be exceeding to 5mb.",
            'category_id.valid_category'   => "Invalid category.",
        ];
    }
}
