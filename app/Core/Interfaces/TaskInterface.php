<?php

namespace App\Core\Interfaces;
 


interface TaskInterface {

	public function fetch($request);

	public function store($request);

	public function update($request, $slug);

	public function updateStatus($slug, $int);

	public function destroy($slug);

	public function findBySlug($slug);

	public function getScheduled();

	public function getByDate($df, $dt);

	public function countNew();
		
}