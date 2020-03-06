<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class ItemCheckInFormRequest extends FormRequest{
    



    public function authorize(){

        return true;
    
    }




    public function rules(){

        return [
            
            'batch_code'=>'required|string|max:45',
            'amount'=>'required|string|max:21',
            'unit'=>'required|string|max:11',
            'expiry_date'=>'required|date_format:"m/d/Y"',
            
        ];

    }




}
