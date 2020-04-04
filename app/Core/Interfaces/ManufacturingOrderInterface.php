<?php

namespace App\Core\Interfaces;
 


interface ManufacturingOrderInterface {

	public function store($job_order);

	public function fetch($request);

	public function updateFillUp($request, $slug);

	public function findBySlug($slug);
	
}