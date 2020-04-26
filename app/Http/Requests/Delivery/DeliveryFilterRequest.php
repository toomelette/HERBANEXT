<?php

namespace App\Http\Requests\Delivery;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryFilterRequest extends FormRequest{



    public function authorize(){
        return true;
    }

    

    public function rules(){

        return [
            'q' => 'nullable|string|max:90',
        ];

    }



}
