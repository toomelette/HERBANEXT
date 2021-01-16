<?php

namespace App\Http\Requests\Machine;

use Illuminate\Foundation\Http\FormRequest;

class MachineUpdateStatusFormRequest extends FormRequest{


    

    public function authorize(){
        return true;
    }

    


    public function rules(){

        return [

            'status'=>'required|int|max:1',
            
        ];

    }







}
