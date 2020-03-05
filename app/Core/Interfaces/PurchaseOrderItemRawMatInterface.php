<?php

namespace App\Core\Interfaces;
 


interface PurchaseOrderItemRawMatInterface {

	public function store($po_no, $po_item_id, $item_raw_mat);
		
}