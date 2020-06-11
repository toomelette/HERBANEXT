<?php

namespace App\Core\Interfaces;
 


interface JobOrderInterface {

	public function fetch($request);

	public function store($po_item);

	public function findBySlug($slug);

	public function updateGenerateFillPost($data);

	public function updateDeliveryStatus($jo_id, $int);

	public function getAll();
	
}