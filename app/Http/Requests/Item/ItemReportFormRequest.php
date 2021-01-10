<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class ItemReportFormRequest extends FormRequest{
    


    public function authorize(){

        return true;
    
    }




    public function rules(){

        return [
            
            'type'=>'required|int|max:2',
            's'=>'required|int|max:2',
            'ic'=>'nullable|string|max:11',
            'sb'=>'required|int|max:2',
            
        ];

    }



}
