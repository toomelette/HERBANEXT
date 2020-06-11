<?php

namespace App\Http\Requests\JobOrder;

use Illuminate\Foundation\Http\FormRequest;

class JobOrderFilterRequest extends FormRequest{



    public function authorize(){
        return true;
    }


    
    public function rules(){
        return [
            'q' => 'nullable|string|max:90',  
        ];
    }



}
