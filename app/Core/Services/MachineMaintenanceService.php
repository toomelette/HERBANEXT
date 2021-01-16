<?php
 
namespace App\Core\Services;


use App\Core\Interfaces\MachineMaintenanceInterface;
use App\Core\BaseClasses\BaseService;


class MachineMaintenanceService extends BaseService{



    protected $machine_maintenance_repo;



    public function __construct(MachineMaintenanceInterface $machine_maintenance_repo){

        $this->machine_maintenance_repo = $machine_maintenance_repo;
        parent::__construct();

    }



    public function fetch($request){

        $machine_maintenance_list = $this->machine_maintenance_repo->fetch($request);
        $request->flash();
        return view('dashboard.machine.maintenance')->with('machine_maintenance_list', $machine_maintenance_list);

    }



    public function store($request){

        $machine_maintenance = $this->machine_maintenance_repo->store($request);
        $this->event->fire('machine_maintenance.store', $machine_maintenance);
        return redirect()->back();

    }



    public function update($request, $slug){

        $machine_maintenance = $this->machine_maintenance_repo->update($request, $slug);
        $this->event->fire('machine_maintenance.update', $machine_maintenance);
        return redirect()->back();

    }



    public function destroy($slug){

        $machine_maintenance = $this->machine_maintenance_repo->destroy($slug);
        $this->event->fire('machine_maintenance.destroy', $machine_maintenance);
        return redirect()->back();

    }



    public function calendar(){

        $machine_maintenance_list = $this->machine_maintenance_repo->getAll();
        return view('dashboard.machine.maintenance_calendar')->with('machine_maintenance_list', $machine_maintenance_list);

    }

    



}