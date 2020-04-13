<?php

namespace App\Http\Requests\Personnel;

use Illuminate\Foundation\Http\FormRequest;

class PersonnelFilterRequest extends FormRequest{



    public function authorize(){
        return true;
    }

 

    public function rules(){

        return [
            'q' => 'nullable|string|max:90',
        ];

    }


    
}
