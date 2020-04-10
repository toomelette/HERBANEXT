<?php

namespace App\Http\Requests\FinishingOrder;

use Illuminate\Foundation\Http\FormRequest;

class FinishingOrderFilterRequest extends FormRequest{


    

    public function authorize(){

        return true;
    
    }

    


    public function rules(){

        return [
            'q' => 'nullable|string|max:90',
        ];

    }


}
