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
            
            'name'=>'required|string|max:45',
            'route'=>'required|string|max:45',
            'icon'=>'required|string|max:45',
            'is_menu'=>'required|string|max:11',
            'is_dropdown'=>'required|string|max:5',

        ];


        if(!empty($rows)){

            foreach($rows as $key => $value){
                    
                $rules['row.'.$key.'.sub_name'] = 'required|string|max:45';
                $rules['row.'.$key.'.sub_route'] = 'required|string|max:45';
                $rules['row.'.$key.'.sub_is_nav'] = 'required|string|max:11';

            } 

        }

        return $rules;

    }







}
