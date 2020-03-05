<?php

namespace App\Core\Interfaces;
 


interface PurchaseOrderItemPackMatInterface {

	public function store($po_no, $po_item_id, $item_raw_mat);
		
}