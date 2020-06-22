<?php

namespace App\Http\Requests\EngrTask;

use Illuminate\Foundation\Http\FormRequest;

class EngrTaskFormRequest extends FormRequest{



    public function authorize(){
        return true;
    }

    

    public function rules(){

        return [

            'cat' => 'required|string|max:2',
            'requested_by' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:90',
            'location' => 'nullable|string|max:255',
            'description' => 'required|string|max:255',
            'pic' => 'nullable|string|max:255',
            'color' => 'required|string|max:45',
            'personnels' => 'nullable|array',

        ];

    }



}
