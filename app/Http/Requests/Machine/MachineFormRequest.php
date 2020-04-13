<?php

namespace App\Http\Requests\Machine;

use Illuminate\Foundation\Http\FormRequest;

class MachineFormRequest extends FormRequest{


    

    public function authorize(){
        return true;
    }

    


    public function rules(){

        return [

            'name'=>'required|string|max:255',
            'description'=>'nullable|string|max:255',
            
        ];

    }







}
