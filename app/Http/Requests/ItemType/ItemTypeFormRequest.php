<?php

namespace App\Http\Requests\ItemType;

use Illuminate\Foundation\Http\FormRequest;

class ItemTypeFormRequest extends FormRequest{
    

    public function authorize(){

        return true;
    
    }




    public function rules(){

        return [

            'name'=>'required|string|max:90',
            'percent'=>'required|int|max:1000',
            
        ];

    }


}
