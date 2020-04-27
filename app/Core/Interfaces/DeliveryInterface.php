<?php

namespace App\Core\Interfaces;
 


interface DeliveryInterface {

	public function fetch($request);

	public function store($request);

	public function update($request, $delivery);

	public function destroy($delivery);

	public function findBySlug($slug);
	
}