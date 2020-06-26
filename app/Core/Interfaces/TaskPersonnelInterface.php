<?php

namespace App\Core\Interfaces;
 


interface TaskPersonnelInterface {

	public function store($task_id, $personnel_id);

	public function updateRating($task_personnel_id, $request);

	public function personnelRatingThisMonth();

}