<?php

namespace App\Http\Requests\PurchaseOrder;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseOrderFormRequest extends FormRequest{



    
    public function authorize(){

        return true;
    
    }

    


    public function rules(){

        $rules = [
            
            'po_no'=>'required|string|max:45',
            'date_required'=>'required|date_format:"m/d/Y"',
            'buffer_status'=>'sometimes|required|string|max:5',
            'bill_to_name'=>'required|string|max:255',
            'bill_to_company'=>'required|string|max:255',
            'bill_to_address'=>'required|string|max:255',
            'ship_to_name'=>'required|string|max:255',
            'ship_to_company'=>'required|string|max:255',
            'ship_to_address'=>'required|string|max:255',
            'vat'=>'required|string|max:21',
            'freight_fee'=>'nullable|string|max:21',
            'instructions'=>'nullable|string|max:255',

        ];


        if(!empty($this->request->get('row'))){

            foreach($this->request->get('row') as $key => $value){
                
                $rules['row.'.$key.'.unit_type_id'] = 'string|max:11';
                $rules['row.'.$key.'.item'] = 'required|string|max:11';
                $rules['row.'.$key.'.amount'] = 'required|string|max:21';
                $rules['row.'.$key.'.unit'] = 'nullable|string|max:11'; 

            } 

        }

        return $rules;

    }


}
