<?php

namespace App\Core\Interfaces;
 


interface PurchaseOrderItemInterface {

	public function fetch($request);

	public function store($data, $item, $purchase_order, $line_price);

	public function updateDeliveryStatus($po_item_id, $int);
	public function updateIsGenerated($slug, $int);

	public function getAll();
		
}