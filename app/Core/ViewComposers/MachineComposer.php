<?php

namespace App\Core\ViewComposers;


use View;
use App\Core\Interfaces\MachineInterface;


class MachineComposer{
   

	protected $machine_repo;


	public function __construct(MachineInterface $machine_repo){
		$this->machine_repo = $machine_repo;
	}


    public function compose($view){
        $machines = $this->machine_repo->getAll();
    	$view->with('global_machines_all', $machines);
    }


}