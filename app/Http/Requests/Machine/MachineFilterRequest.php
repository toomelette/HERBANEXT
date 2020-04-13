<?php

namespace App\Http\Requests\Machine;

use Illuminate\Foundation\Http\FormRequest;

class MachineFilterRequest extends FormRequest{



    public function authorize(){
        return true;
    }

 

    public function rules(){

        return [
            'q' => 'nullable|string|max:90',
        ];

    }


    
}
