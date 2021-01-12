<?php

namespace App\Core\Interfaces;
 


interface ItemBatchInterface {

	public function fetchByItem($product_code, $request);

	public function store($request, $item);

	public function updateCheckIn($batch_code, $amount);

	public function updateCheckOut($batch_id, $amount);

	public function updateCheckOutByBatchCode($batch_code, $amount);

	public function updateRemarks($batch_id, $remarks);

	public function getAll();

	public function getByItemId($item_id);
		
}