<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class TaskRatePersonnelFormRequest extends FormRequest{



    public function authorize(){
        return true;
    }

    

    public function rules(){

        return [

            'rating' => 'required|int|min:1|max:5',
            'remarks' => 'nullable|max:255',

        ];

    }



}
