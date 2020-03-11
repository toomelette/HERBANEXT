<?php

namespace App\Http\Requests\JobOrder;

use Illuminate\Foundation\Http\FormRequest;

class JobOrderGenerateFormRequest extends FormRequest{


    

    public function authorize(){

        return true;
    
    }

    


    public function rules(){

        return [

            'jo_no' => 'required|string|max:45',
            'no_of_batch' => 'required|int|max:50',
            
        ];

    }


}
