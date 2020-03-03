<?php

namespace App\Http\Requests\PurchaseOrder;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseOrderFilterRequest extends FormRequest{
    


    public function authorize(){

        return true;
    
    }




    public function rules(){

        return [
            
            'q'=>'nullable|string|max:90',
            'df'=>'nullable|date_format:"m/d/Y"',
            'dt'=>'nullable|date_format:"m/d/Y"',
            
        ];

    }



}
