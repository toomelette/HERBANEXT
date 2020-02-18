<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class ItemBatchByItemFilterRequest extends FormRequest{
    


    public function authorize(){

        return true;
    
    }




    public function rules(){

        return [
            
            'q'=>'nullable|string|max:90',
            
        ];

    }



}