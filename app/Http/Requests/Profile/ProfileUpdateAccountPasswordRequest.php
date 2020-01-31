<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateAccountPasswordRequest extends FormRequest{


    
    public function authorize(){

        return true;
    
    }

    



     public function rules(){

        return [

            'old_password' => 'required|max:45|string',
            'password' => 'required|min:6|max:45|string|confirmed'

        ];

    }





}
