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
            'time_from' => 'required|date_format:"h:i A"',
            'date_to'=>'required|date_format:"m/d/Y"',
            'time_to' => 'required|date_format:"h:i A"',
            'description'=>'required|string|max:255',
            'remarks'=>'nullable|string|max:255',
            
        ];

    }







}
