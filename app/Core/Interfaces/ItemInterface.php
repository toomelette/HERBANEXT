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

	public function findByItemId($item_id);

	public function getAll();

	public function getRawMats();

	public function getPackMats();

	public function getByItemId($item_id);

	public function inventoryByCategory($request);

	public function inventoryAll($request);
		
		
}