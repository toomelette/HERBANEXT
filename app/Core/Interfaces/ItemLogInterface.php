<?php

namespace App\Core\Interfaces;
 


interface ItemLogInterface {

	public function fetchByItem($product_code, $request);

	public function storeCheckIn($request, $item);
		
	public function storeCheckOut($request, $item);
		
	public function fetch($request);

}