<?php

namespace App\Core\Interfaces;
 


interface PurchaseOrderItemInterface {

	public function store($data, $item, $purchase_order, $line_price);
		
}