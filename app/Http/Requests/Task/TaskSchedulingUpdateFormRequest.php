<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class TaskSchedulingUpdateFormRequest extends FormRequest{


    

    public function authorize(){
        return true;
    }

    


    public function rules(){

        return [

            'e_slug'=>'required|string|max:45',
            'e_date_from'=>'required|date_format:"m/d/Y"',
            'e_time_from' => 'required|date_format:"h:i A"',
            'e_date_to'=>'required|date_format:"m/d/Y"',
            'e_time_to' => 'required|date_format:"h:i A"',

        ];

    }







}
