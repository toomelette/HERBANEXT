<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserResetPasswordRequest extends FormRequest{


    
    public function authorize(){

        return true;
    
    }



    public function rules(){

        return [

            'username' => 'required|max:45|string',
            'user_password' => 'required|max:45|string',
            'password' => 'required|min:6|max:45|string|confirmed'

        ];

    }




}
