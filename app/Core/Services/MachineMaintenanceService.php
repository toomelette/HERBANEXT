<?php
 
namespace App\Core\Services;


use App\Core\Interfaces\MachineMaintenanceInterface;
use App\Core\BaseClasses\BaseService;


class MachineMaintenanceService extends BaseService{



    protected $machine_mnt_repo;



    public function __construct(MachineMaintenanceInterface $machine_mnt_repo){

        $this->machine_mnt_repo = $machine_mnt_repo;
        parent::__construct();

    }



    public function store($request){

        $machine_mnt = $this->machine_mnt_repo->store($request);
        $this->event->fire('machine_mnt.store', $machine_mnt);
        return redirect()->back();

    }



    public function update($request, $slug){

        $machine_mnt = $this->machine_mnt_repo->update($request, $slug);
        $this->event->fire('machine_mnt.update', $machine_mnt);
        return redirect()->back();

    }



    public function destroy($slug){

        $machine_mnt = $this->machine_mnt_repo->destroy($slug);
        $this->event->fire('machine_mnt.destroy', $machine_mnt);
        return redirect()->back();

    }




}