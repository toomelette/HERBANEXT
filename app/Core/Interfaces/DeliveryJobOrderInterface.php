<?php

namespace App\Core\Interfaces;
 
interface DeliveryJobOrderInterface {

	public function store($delivery_id, $jo_id);

}