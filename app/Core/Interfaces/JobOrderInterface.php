<?php

namespace App\Core\Interfaces;
 


interface JobOrderInterface {

	public function store($request, $purchase_order_item, $batch_size);
	
}