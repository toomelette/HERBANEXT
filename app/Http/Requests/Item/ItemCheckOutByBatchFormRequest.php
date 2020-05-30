<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class ItemCheckOutByBatchFormRequest extends FormRequest{
    



    public function authorize(){

        return true;
    
    }




    public function rules(){

        return [
            
            'batch_code'=>'required|string|max:45',
            'amount'=>'required|string|max:21',
            'unit'=>'required|string|max:11',
            'remarks'=>'nullable|string|max:255',
            
        ];

    }




}
