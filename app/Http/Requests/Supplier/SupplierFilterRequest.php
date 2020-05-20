<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class SupplierFilterRequest extends FormRequest{



    public function authorize(){
        return true;
    }

 

    public function rules(){

        return [
            'q' => 'nullable|string|max:90',
        ];

    }


    
}
