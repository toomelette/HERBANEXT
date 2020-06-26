<?php

namespace App\Core\Interfaces;
 


interface EngrTaskPersonnelInterface {

	public function store($engr_task_id, $personnel_id);

	public function updateRating($engr_task_personnel_id, $request);

	// public function personnelRatingThisMonth();

}