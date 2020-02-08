<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class ItemFormRequest extends FormRequest{
    



    public function authorize(){

        return true;
    
    }




    public function rules(){

        return [
            
            'product_code'=>'required|string|max:45',
            'name'=>'required|string|max:255',
            'description'=>'nullable|string|max:255',
            
            'item_unit_id'=>'required|string|max:11',
            'weight'=>'nullable|numeric|max:1000000000',
            'weight_unit'=>'nullable|string|max:11',
            'quantity'=>'nullable|numeric|max:1000000000',
            'min_req_qty'=>'required|numeric|max:1000000000',
            'price'=>'nullable|numeric|max:1000000000',
            
        ];

    }




}
