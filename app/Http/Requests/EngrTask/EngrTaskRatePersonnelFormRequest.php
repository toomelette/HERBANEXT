<?php

namespace App\Http\Requests\EngrTask;

use Illuminate\Foundation\Http\FormRequest;

class EngrTaskRatePersonnelFormRequest extends FormRequest{



    public function authorize(){
        return true;
    }

    

    public function rules(){

        return [

            'rating' => 'required|int|min:1|max:5',
            'rating' => 'nullable|max:255',

        ];

    }



}
