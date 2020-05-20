<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class SupplierFormRequest extends FormRequest{


    

    public function authorize(){

        return true;
    
    }

    


    public function rules(){

        return [
            'name'=>'required|string|max:255',
            'description'=>'nullable|string|max:255',
            'address'=>'nullable|string|max:255',
            'contact_no'=>'nullable|string|max:45',
            'contact_person'=>'nullable|string|max:90',
        ];

    }







}
