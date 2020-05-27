<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class ItemCheckInExistingBatchFormRequest extends FormRequest{
    



    public function authorize(){

        return true;
    
    }




    public function rules(){

        return [

            
            
        ];

    }




}
