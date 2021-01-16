<?php

namespace App\Core\Interfaces;
 


interface MachineMaintenanceInterface {

	public function fetch($request);

	public function store($request);

	public function update($request, $slug);

	public function destroy($slug);
	
	public function getAll();

}