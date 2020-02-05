<?php

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

class MenuFormRequest extends FormRequest{


    

    public function authorize(){

        return true;
    
    }

    


    public function rules(){
        
        $rows = $this->request->get('row');

        $rules = [
            
            'name'=>'required|string|max:90',
            'route'=>'required|string|max:90',
            'icon'=>'required|string|max:90',
            'is_menu'=>'required|string|max:5',
            'is_dropdown'=>'required|string|max:5',

        ];


        if(!empty($rows)){

            foreach($rows as $key => $value){
                
                $rules['row.'.$key.'.sub_submenu_id'] = 'required|string|max:11';
                $rules['row.'.$key.'.sub_name'] = 'required|string|max:90';
                $rules['row.'.$key.'.sub_nav_name'] = 'nullable|string|max:90';
                $rules['row.'.$key.'.sub_route'] = 'required|string|max:90';
                $rules['row.'.$key.'.sub_is_nav'] = 'required|string|max:11';

            } 

        }

        return $rules;

    }







}
