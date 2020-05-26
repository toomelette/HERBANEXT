<?php

namespace App\Http\Requests\Delivery;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryFormRequest extends FormRequest{



    public function authorize(){
        return true;
    }

    

    public function rules(){

        return [

            'is_organic' => 'required|string|max:5',
            'delivery_code' => 'required|string|max:45',
            'description' => 'nullable|string|max:255',
            'date'=>'required|date_format:"m/d/Y"',
            'po_items' => 'nullable|array',
            'jo' => 'nullable|array',

        ];

    }



}
