<?php

namespace App\Http\Requests\MachineMaintenance;

use Illuminate\Foundation\Http\FormRequest;

class MachineMaintenanceModalFormRequest extends FormRequest{


    

    public function authorize(){
        return true;
    }

    


    public function rules(){

        return [

            'e_machine_id'=>'required|string|max:11',
            'e_date_from'=>'required|date_format:"m/d/Y"',
            'e_time_from' => 'required|date_format:"h:i A"',
            'e_date_to'=>'required|date_format:"m/d/Y"',
            'e_time_to' => 'required|date_format:"h:i A"',
            'e_description'=>'required|string|max:255',
            'e_remarks'=>'nullable|string|max:255',
            
        ];

    }







}
