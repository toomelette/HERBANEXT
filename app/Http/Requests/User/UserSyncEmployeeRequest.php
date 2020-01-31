<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserSyncEmployeeRequest extends FormRequest{



    public function authorize(){

        return true;

    }





    public function rules(){
        
        return [
            's' => 'required|max:45|string',
        ];
    
    }




}
