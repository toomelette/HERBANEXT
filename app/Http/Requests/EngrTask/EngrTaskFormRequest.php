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
            'name' => 'required|string|max:255',
            'jo_no' => 'nullable|string|max:45',
            'requested_by' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:90',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'pic' => 'nullable|string|max:255',
            'date_from'=>'required|date_format:"m/d/Y"',
            'time_from' => 'required|date_format:"h:i A"',
            'date_to'=>'required|date_format:"m/d/Y"',
            'time_to' => 'required|date_format:"h:i A"',
            'personnels' => 'nullable|array',

        ];

    }



}
