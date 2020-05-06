<?php

namespace App\Core\Interfaces;
 


interface JobOrderInterface {

	public function store($po_item);

	public function updateGenerateFillPost($data);

	public function updateIsReady($jo_id, $bool);

	public function getAll();
	
}