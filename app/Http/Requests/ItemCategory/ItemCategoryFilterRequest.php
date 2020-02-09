<?php

namespace App\Http\Requests\ItemCategory;

use Illuminate\Foundation\Http\FormRequest;

class ItemCategoryFilterRequest extends FormRequest{
    

    public function authorize(){

        return true;
    
    }




    public function rules(){

        return [

            'q'=>'nullable|string|max:90',
            
        ];

    }
    


}
