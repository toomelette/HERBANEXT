<?php

namespace App\Core\Interfaces;
 
interface FinishingOrderPackMatInterface {

	public function store($mo, $item_pack_mat);

	public function update($data);

	public function updateFigures($data);
	
}