<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class TaskReportFormRequest extends FormRequest{



    public function authorize(){
        return true;
    }

    

    public function rules(){

        return [

        	'ft' => 'required|string|max:5',
            'ts_df' => 'required|date_format:"m/d/Y"',
            'ts_dt' => 'required|date_format:"m/d/Y"',

        ];

    }



}
