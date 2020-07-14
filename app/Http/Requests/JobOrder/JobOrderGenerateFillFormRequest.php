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
                
                $rules['row.'.$key.'.jo_id'] = 'required|string|max:11';
                $rules['row.'.$key.'.jo_no'] = 'required|string|max:45';
                $rules['row.'.$key.'.date'] = 'nullable|date_format:"m/d/Y"';
                $rules['row.'.$key.'.lot_no'] = 'nullable|string|max:45';
                $rules['row.'.$key.'.batch_size'] = 'nullable|string|max:255';
                $rules['row.'.$key.'.pack_size'] = 'nullable|string|max:255';
                $rules['row.'.$key.'.theo_yield'] = 'nullable|string|max:255';

            } 

        }

        return $rules;

    }







}
