<?php

namespace App\Http\Requests\ManufacturingOrder;

use Illuminate\Foundation\Http\FormRequest;

class ManufacturingOrderFillRequest extends FormRequest{


    

    public function authorize(){

        return true;
    
    }

    


    public function rules(){

        $rows = $this->request->get('row');

        $rules = [
            
            'master_mo_no'=>'required|string|max:45',
            'mo_no'=>'required|string|max:45',
            'client'=>'required|string|max:255',
            'shelf_life'=>'required|string|max:255',
            'processing_date'=>'required|date_format:"m/d/Y"',
            'expired_date'=>'required|date_format:"m/d/Y"',
            'requested_date'=>'required|date_format:"m/d/Y"',
            'requested_by'=>'required|string|max:255',
            'status'=>'required|string|max:255',
        ];


        if(!empty($rows)){

            foreach($rows as $key => $value){
                
                $rules['row.'.$key.'.item_product_code'] = 'required|string|max:11';
                $rules['row.'.$key.'.item_name'] = 'required|string|max:255';
                $rules['row.'.$key.'.req_qty'] = 'required|string|max:21';
                $rules['row.'.$key.'.req_qty_unit'] = 'required|string|max:45';
                $rules['row.'.$key.'.req_qty_is_included'] = 'nullable|string|max:5';
                $rules['row.'.$key.'.batch_no'] = 'nullable|string|max:45';
                $rules['row.'.$key.'.weighed_by'] = 'nullable|string|max:255';

            } 

        }

        return $rules;

    }







}
