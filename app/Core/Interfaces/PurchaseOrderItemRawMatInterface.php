<?php

namespace App\Core\Interfaces;
 


interface PurchaseOrderItemRawMatInterface {

	public function store($purchase_order, $po_item_id, $item_raw_mat);
		
}