<?php

namespace App\Http\Controllers;


use App\Core\Services\MachineMaintenanceService;
use App\Http\Requests\MachineMaintenance\MachineMaintenanceFormRequest;
use App\Http\Requests\MachineMaintenance\MachineMaintenanceModalFormRequest;


class MachineMaintenanceController extends Controller{


    protected $machine_mnt;


    public function __construct(MachineMaintenanceService $machine_mnt){
        $this->machine_mnt = $machine_mnt;
    }

   
    public function store(MachineMaintenanceFormRequest $request){
        return $this->machine_mnt->store($request);
    }


    public function update(MachineMaintenanceModalFormRequest $request, $slug){
        return $this->machine_mnt->update($request, $slug);
    }

    
    public function destroy($slug){
        return $this->machine_mnt->destroy($slug);
    }



}
