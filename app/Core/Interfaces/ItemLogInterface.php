<?php

namespace App\Core\Interfaces;
 


interface ItemLogInterface {
		
	public function fetch($request);

	public function fetchByItem($product_code, $request);

	public function storeCheckIn($request, $item, $item_batch);
		
	public function storeCheckOut($request, $item, $item_batch = null);
		
	public function updateRemarks($id, $request);

	public function checkedOutFinishGoodsCurrentMonth();

	public function getLatest();

}