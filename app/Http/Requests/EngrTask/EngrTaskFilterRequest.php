<?php

namespace App\Http\Requests\EngrTask;

use Illuminate\Foundation\Http\FormRequest;

class EngrTaskFilterRequest extends FormRequest{



    public function authorize(){
        return true;
    }

    

    public function rules(){

        return [

            'q' => 'nullable|string|max:90',

        ];

    }



}
