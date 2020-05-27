<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class ItemCheckInFormRequest extends FormRequest{
    



    public function authorize(){

        return true;
    
    }




    public function rules(){

        return [
            
            'batch_code'=>'required|unique:item_batches|string|max:45',
            'amount'=>'required|string|max:21',
            'unit'=>'required|string|max:11',
            'expiry_date'=>'required|date_format:"m/d/Y"',
            'remarks'=>'nullable|string|max:250',
            
        ];

    }




}
