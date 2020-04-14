<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class TaskFormRequest extends FormRequest{



    public function authorize(){
        return true;
    }

    

    public function rules(){

        return [
            
        ];

    }



}
