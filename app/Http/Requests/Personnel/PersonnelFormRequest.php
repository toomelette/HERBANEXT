<?php

namespace App\Http\Requests\Personnel;

use Illuminate\Foundation\Http\FormRequest;

class PersonnelFormRequest extends FormRequest{


    

    public function authorize(){

        return true;
    
    }

    


    public function rules(){

        return [
            'avatar' => 'nullable|mimes:jpg,jpeg,png|max:50000',
            'firstname'=>'required|string|max:90',
            'middlename'=>'required|string|max:90',
            'lastname'=>'required|string|max:90',
            'position'=>'required|string|max:90',
            'contact_no'=>'nullable|string|max:45',
            'email'=>'nullable|string|max:90',
        ];

    }







}
