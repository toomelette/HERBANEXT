<?php

namespace App\Core\Interfaces;
 


interface ItemCategoryInterface {

	public function fetch($request);

	public function store($request);

	public function update($request, $slug);

	public function destroy($slug);

	public function findBySlug($slug);

	public function findByItemCatId($item_cat_id);

	public function getAll();
		
}