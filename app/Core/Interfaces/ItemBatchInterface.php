<?php

namespace App\Core\Interfaces;
 


interface ItemBatchInterface {

	public function fetchByItem($product_code, $request);

	public function store($request, $item);

	public function updateCheckOut($batch_code, $amount);
		
}