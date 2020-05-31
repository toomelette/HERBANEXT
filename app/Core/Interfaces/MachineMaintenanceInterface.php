<?php

namespace App\Core\Interfaces;
 


interface MachineMaintenanceInterface {

	public function fetchByMachineId($request, $machine_id);

	public function store($request);

	public function update($request, $slug);

	public function destroy($slug);

	public function getBySlug($slug);
		
}