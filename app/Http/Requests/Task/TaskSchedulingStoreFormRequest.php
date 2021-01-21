<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class TaskSchedulingStoreFormRequest extends FormRequest{


    

    public function authorize(){
        return true;
    }

    


    public function rules(){

        return [

            'slug'=>'required|string|max:45',
            'date_from'=>'required|date_format:"m/d/Y"',
            'time_from' => 'required|date_format:"h:i A"',
            'date_to'=>'required|date_format:"m/d/Y"',
            'time_to' => 'required|date_format:"h:i A"',

        ];

    }







}
