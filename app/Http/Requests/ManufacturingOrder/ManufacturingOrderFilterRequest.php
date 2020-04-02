<?php

namespace App\Http\Requests\ManufacturingOrder;

use Illuminate\Foundation\Http\FormRequest;

class ManufacturingOrderFilterRequest extends FormRequest{


    

    public function authorize(){

        return true;
    
    }

    


    public function rules(){

        return [

            'q' => 'nullable|string|max:90',
            
        ];

    }


}
