<?php

namespace App\Core\Interfaces;
 


interface JobOrderInterface {

	public function store($purchase_order_item, $batch_size);

	public function updateGenerateFillPost($data);
	
}