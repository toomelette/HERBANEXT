<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class ItemFormRequest extends FormRequest{
    



    public function authorize(){

        return true;
    
    }




    public function rules(){

        $rules = [
            
            'product_code'=>'required|string|max:45',
            'supplier_id'=>'required|string|max:11',
            'item_category_id'=>'required|string|max:11',
            'item_type_id'=>'required|string|max:11',
            'name'=>'required|string|max:255',
            'description'=>'nullable|string|max:255',
            
            'unit_type_id'=>'sometimes|required|string|max:11',
            'beginning_balance'=>'sometimes|required|string|max:21',
            'unit'=>'sometimes|required|string|max:11',
            'batch_size'=>'nullable|string|max:255',
            'min_req_qty'=>'required|string|max:21',
            'price'=>'nullable|string|max:21',
            
        ];


        if(!empty($this->request->get('row_raw'))){
            foreach($this->request->get('row_raw') as $key => $value){   
                $rules['row_raw.'.$key.'.item'] = 'required|string|max:11';
            } 
        }


        if(!empty($this->request->get('row_pack'))){
            foreach($this->request->get('row_pack') as $key => $value){ 
                $rules['row_pack.'.$key.'.item'] = 'required|string|max:11';
            } 
        }

        return $rules;

    }




}
