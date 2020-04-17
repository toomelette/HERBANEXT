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
            'item_id' => 'required|string|max:11',
            'machine_id' => 'required|string|max:11',
            'color' => 'required|string|max:45',
            'personnels' => 'nullable|array',

        ];

    }



}
