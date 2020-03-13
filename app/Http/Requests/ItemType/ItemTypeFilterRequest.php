<?php

namespace App\Http\Requests\ItemType;

use Illuminate\Foundation\Http\FormRequest;

class ItemTypeFilterRequest extends FormRequest{
    

    public function authorize(){

        return true;
    
    }




    public function rules(){

        return [

            'q'=>'nullable|string|max:90',
            
        ];

    }


}
