<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class TaskFilterRequest extends FormRequest{



    public function authorize(){
        return true;
    }

    

    public function rules(){

        return [
            'q' => 'nullable|string|max:90',
            'i' => 'nullable|string|max:11',
            'm' => 'nullable|string|max:11',
            's' => 'nullable|int|max:3',
        ];

    }



}
