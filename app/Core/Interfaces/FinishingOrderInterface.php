<?php

namespace App\Core\Interfaces;
 


interface FinishingOrderInterface {

	public function store($job_order);

	public function fetch($request);

	public function updateFillUpFromMO($request, $o_id);

	public function updateFillUp($request, $slug);

	public function findBySlug($slug);

	public function findByJOId($jo_id);
	
}