<?php

namespace App\Core\Interfaces;
 


interface UserInterface {
	
	public function fetch($request);

	public function store($request, $img_location);

	public function update($request, $slug, $img_location);

	public function destroy($slug);

	public function activate($slug);

	public function deactivate($slug);

	public function logout($slug);

	public function resetPassword($model, $request);
	
	public function findBySlug($slug);

	public function login($slug);

	public function countByIsOnline($status);
		
}