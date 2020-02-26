<?php

namespace App\Http\Requests\PurchaseOrder;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseOrderFormRequest extends FormRequest{



    
    public function authorize(){

        return true;
    
    }

    


    public function rules(){
       
        $rows = $this->request->get('row');

        $rules = [
            
            'bill_to_name'=>'required|string|max:255',
            'bill_to_company'=>'required|string|max:255',
            'bill_to_address'=>'required|string|max:255',
            'ship_to_name'=>'required|string|max:255',
            'ship_to_company'=>'required|string|max:255',
            'ship_to_address'=>'required|string|max:255',
            'vat'=>'required|string|max:21',
            'freight_fee'=>'nullable|string|max:21',

        ];


        if(!empty($rows)){

            foreach($rows as $key => $value){
                
                $rules['row.'.$key.'.unit_type_id'] = 'string|max:11';
                $rules['row.'.$key.'.item'] = 'required|string|max:11';
                $rules['row.'.$key.'.amount'] = 'required|string|max:21';
                $rules['row.'.$key.'.unit'] = 'nullable|string|max:11'; 

            } 

        }

        return $rules;

    }


}
