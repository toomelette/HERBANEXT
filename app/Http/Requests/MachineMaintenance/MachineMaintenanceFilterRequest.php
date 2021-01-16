<?php

namespace App\Http\Requests\MachineMaintenance;

use Illuminate\Foundation\Http\FormRequest;

class MachineMaintenanceFilterRequest extends FormRequest{


    

    public function authorize(){
        return true;
    }

    


    public function rules(){

        return [

            'q'=>'nullable|string|max:255',
            
        ];

    }







}
