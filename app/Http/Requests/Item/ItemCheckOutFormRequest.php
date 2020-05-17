<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class ItemCheckOutFormRequest extends FormRequest{
    



    public function authorize(){

        return true;
    
    }




    public function rules(){

        return [
            
            'amount'=>'required|string|max:21',
            'unit'=>'required|string|max:11',
            'remarks'=>'nullable|string|max:250',
            
        ];

    }




}
