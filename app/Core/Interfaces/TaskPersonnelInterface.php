<?php

namespace App\Core\Interfaces;
 


interface TaskPersonnelInterface {

	public function store($task_id, $personnel_id);

	public function updateRating($task_personnel_id, $rating);

	public function personnelRatingThisMonth();

}