<?php

namespace App\Http\Requests\MachineMaintenance;

use Illuminate\Foundation\Http\FormRequest;

class MachineMaintenanceFormRequest extends FormRequest{


    

    public function authorize(){
        return true;
    }

    


    public function rules(){

        return [

            'machine_id'=>'required|string|max:11',
            'date_from'=>'required|date_format:"m/d/Y"',
            'date_to'=>'required|date_format:"m/d/Y"',
            'description'=>'required|string|max:255',
            
        ];

    }







}
