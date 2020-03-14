<?php

namespace App\Http\Requests\JobOrder;

use Illuminate\Foundation\Http\FormRequest;

class JobOrderGenerateFillFormRequest extends FormRequest{


    

    public function authorize(){

        return true;
    
    }

    


    public function rules(){

        $rules = [];
        
        if(!empty($this->request->get('row'))){

            foreach($this->request->get('row') as $key => $value){
                
                $rules['row.'.$key.'.date'] = 'required|date_format:"m/d/Y"';
                $rules['row.'.$key.'.pack_size'] = 'required|string|max:21';
                $rules['row.'.$key.'.pack_size_unit'] = 'required|string|max:45';
                $rules['row.'.$key.'.theo_yield'] = 'required|string|max:21';
                $rules['row.'.$key.'.theo_yield_unit'] = 'required|string|max:45';

            } 

        }

        return $rules;

    }







}
