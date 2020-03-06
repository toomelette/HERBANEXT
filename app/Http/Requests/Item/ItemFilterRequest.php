<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class ItemFilterRequest extends FormRequest{
    


    public function authorize(){

        return true;
    
    }




    public function rules(){

        return [
            
            'q'=>'nullable|string|max:90',
            'cat'=>'nullable|string|max:11',
            
        ];

    }



}
