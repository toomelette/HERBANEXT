<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Core\Interfaces\MachineMaintenanceInterface;
use Illuminate\Http\Request;

class ApiMachineMaintenanceController extends Controller{



	protected $machine_mnt_repo;



	public function __construct(MachineMaintenanceInterface $machine_mnt_repo){

		$this->machine_mnt_repo = $machine_mnt_repo;

	}



	public function edit(Request $request, $slug){

    	if($request->Ajax()){
    		$response_machine_mnt = $this->machine_mnt_repo->getBySlug($slug);
	    	return json_encode($response_machine_mnt);
	    }

	    return abort(404);

    }


    
}
