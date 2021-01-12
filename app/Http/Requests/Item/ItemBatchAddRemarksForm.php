<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class ItemBatchAddRemarksForm extends FormRequest{
    


    public function authorize(){

        return true;
    
    }




    public function rules(){

        return [
            
            'remarks'=>'nullable|string|max:255',
            
        ];

    }



}