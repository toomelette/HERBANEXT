<?php

namespace App\Http\Requests\FinishingOrder;

use Illuminate\Foundation\Http\FormRequest;

class FinishingOrderFillRequest extends FormRequest{


    

    public function authorize(){

        return true;
    
    }

    


    public function rules(){

        $rules = [
            
            'master_fo_no'=>'required|string|max:45',
            'fo_no'=>'required|string|max:45',
            'client'=>'required|string|max:255',
            'shell_life'=>'required|string|max:255',
            'processing_date'=>'required|date_format:"m/d/Y"',
            'expired_date'=>'required|date_format:"m/d/Y"',
            'requested_date'=>'required|date_format:"m/d/Y"',
            'requested_by'=>'required|string|max:255',
            'status'=>'required|string|max:255',
        ];


        if(!empty($this->request->get('row'))){
            foreach($this->request->get('row') as $key => $value){
                $rules['row.'.$key.'.unit_type_id'] = 'required|string|max:11';
                $rules['row.'.$key.'.item_product_code'] = 'required|string|max:11';
                $rules['row.'.$key.'.item_name'] = 'required|string|max:255';
                $rules['row.'.$key.'.req_qty'] = 'required|string|max:21';
                $rules['row.'.$key.'.req_qty_unit'] = 'required|string|max:45';
                $rules['row.'.$key.'.qty_issued'] = 'required|string|max:21';
                $rules['row.'.$key.'.qty_issued_unit'] = 'required|string|max:45';
            } 
        }


        if(!empty($this->request->get('row_figure'))){
            foreach($this->request->get('row_figure') as $key_figure => $value_figure){
                $rules['row_figure.'.$key_figure.'.unit_type_id'] = 'required|string|max:11';
                $rules['row_figure.'.$key_figure.'.figure_unit'] = 'required|string|max:45';
                $rules['row_figure.'.$key_figure.'.figure_regected'] = 'required|string|max:21';
                $rules['row_figure.'.$key_figure.'.figure_damaged'] = 'required|string|max:21';
                $rules['row_figure.'.$key_figure.'.figure_returns'] = 'required|string|max:21';
                $rules['row_figure.'.$key_figure.'.figure_samples'] = 'required|string|max:21';
                $rules['row_figure.'.$key_figure.'.figure_total'] = 'required|string|max:21';
                $rules['row_figure.'.$key_figure.'.figure_difference'] = 'required|string|max:21';
            } 
        }

        return $rules;

    }







}
