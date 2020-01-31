<?php

namespace App\Core\Interfaces;
 


interface MenuInterface {

	public function fetch($request);

	public function store($request);

	public function update($request, $slug);

	public function destroy($slug);

	public function findBySlug($menu_id);

	public function findByMenuId($menu_id);

	public function getAll();
		
}