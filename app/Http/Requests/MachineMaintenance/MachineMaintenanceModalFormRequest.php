<?php

namespace App\Http\Requests\MachineMaintenance;

use Illuminate\Foundation\Http\FormRequest;

class MachineMaintenanceModalFormRequest extends FormRequest{


    

    public function authorize(){
        return true;
    }

    

    public function rules(){

        return [

            'e_date_from'=>'required|date_format:"m/d/Y"',
            'e_date_to'=>'required|date_format:"m/d/Y"',
            'e_description'=>'required|string|max:255',
            
        ];

    }



}
