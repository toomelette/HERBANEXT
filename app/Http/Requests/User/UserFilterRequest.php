<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserFilterRequest extends FormRequest{

    
    public function authorize(){

        return true;
    }

   
    public function rules(){

        return [

            'ol' => 'nullable|string|max:11',
            'a' => 'nullable|string|max:11',

        ];

    }




}
