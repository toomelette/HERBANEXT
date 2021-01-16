<?php

namespace App\Http\Controllers;


use App\Core\Services\MachineMaintenanceService;
use App\Http\Requests\MachineMaintenance\MachineMaintenanceFormRequest;
use App\Http\Requests\MachineMaintenance\MachineMaintenanceModalFormRequest;
use App\Http\Requests\MachineMaintenance\MachineMaintenanceFilterRequest;


class MachineMaintenanceController extends Controller{


    protected $machine_maintenance;


    public function __construct(MachineMaintenanceService $machine_maintenance){
        $this->machine_maintenance = $machine_maintenance;
    }

    

   
    public function index(MachineMaintenanceFilterRequest $request){
        return $this->machine_maintenance->fetch($request);
    }

   
    public function store(MachineMaintenanceFormRequest $request){
        return $this->machine_maintenance->store($request);
    }


    public function update(MachineMaintenanceModalFormRequest $request, $slug){
        return $this->machine_maintenance->update($request, $slug);
    }

    
    public function delete($slug){
        return $this->machine_maintenance->destroy($slug);
    }

    
    public function calendar(){
        return $this->machine_maintenance->calendar();
    }



}
