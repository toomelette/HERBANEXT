<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class ItemFormRequest extends FormRequest{
    



    public function authorize(){

        return true;
    
    }




    public function rules(){

        return [
            
            'product_code'=>'required|string|max:45|unique:items,product_code,'.$this->route('item').',slug',
            'item_category_id'=>'required|string|max:11',
            'name'=>'required|string|max:255',
            'description'=>'nullable|string|max:255',
            
            'unit_type_id'=>'sometimes|required|string|max:11',
            'beginning_balance'=>'sometimes|required|string|max:21',
            'unit'=>'sometimes|required|string|max:11',
            'min_req_qty'=>'required|string|max:21',
            'price'=>'nullable|string|max:21',
            
        ];

    }




}
