<?php

namespace App\Core\Interfaces;
 


interface PurchaseOrderItemPackMatInterface {

	public function store($purchase_order, $po_item_id, $item_raw_mat);
		
}