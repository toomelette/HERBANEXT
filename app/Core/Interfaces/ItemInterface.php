<?php

namespace App\Core\Interfaces;
 


interface ItemInterface {

	public function fetch($request);

	public function store($request);

	public function update($request, $slug);

	public function updateCheckIn($amount, $item);

	public function updateCheckOut($amount, $item);

	public function destroy($slug);

	public function findBySlug($slug);

	public function findByProductCode($product_code);

	public function getAll();

	public function getRawMats();

	public function getPackMats();

	public function getByProductCode($product_code);
		
		
}