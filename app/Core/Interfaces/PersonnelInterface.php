<?php

namespace App\Core\Interfaces;
 


interface PersonnelInterface {

	public function fetch($request);

	public function store($request, $img_location);

	public function update($request, $slug, $img_location);

	public function destroy($slug);

	public function findBySlug($slug);

	public function getAll();
		
}