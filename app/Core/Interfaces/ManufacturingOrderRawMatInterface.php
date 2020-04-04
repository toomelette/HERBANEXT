<?php

namespace App\Core\Interfaces;
 
interface ManufacturingOrderRawMatInterface {

	public function store($mo, $item_raw_mat);

	public function update($data);
	
}