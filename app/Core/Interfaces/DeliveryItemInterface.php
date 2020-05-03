<?php

namespace App\Core\Interfaces;
 
interface DeliveryItemInterface {

	public function store($delivery_id, $po_item_id);

}