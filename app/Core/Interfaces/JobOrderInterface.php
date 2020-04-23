<?php

namespace App\Core\Interfaces;
 


interface JobOrderInterface {

	public function store($po_item);

	public function updateGenerateFillPost($data);

	public function updateDeliveryStatus($jo_id, $int);
	
}