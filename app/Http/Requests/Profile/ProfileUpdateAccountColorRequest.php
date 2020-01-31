<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateAccountColorRequest extends FormRequest{




    public function authorize(){
        
        return true;
    
    }



    public function rules(){

        return [

            'color' => 'required|max:45|string',

        ];

    }




}
