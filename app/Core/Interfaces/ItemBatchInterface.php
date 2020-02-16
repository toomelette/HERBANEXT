<?php

namespace App\Core\Interfaces;
 


interface ItemBatchInterface {

	public function store($request, $item);

	public function updateCheckOut($batch_code, $amount);
		
}