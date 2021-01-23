<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class TaskFormRequest extends FormRequest{



    public function authorize(){
        return true;
    }

    

    public function rules(){

        return [

            'name' => 'required|string|max:90',
            'description' => 'nullable|string|max:255',
            'item_id' => 'nullable|string|max:11',
            'machine_id' => 'required|string|max:11',
            'date_from'=>'required|date_format:"m/d/Y"',
            'time_from' => 'required|date_format:"h:i A"',
            'date_to'=>'required|date_format:"m/d/Y"',
            'time_to' => 'required|date_format:"h:i A"',
            'personnels' => 'nullable|array',

        ];

    }



}
