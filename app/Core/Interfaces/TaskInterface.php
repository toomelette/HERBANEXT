<?php

namespace App\Core\Interfaces;
 


interface TaskInterface {

	public function fetch($request);

	public function fetchByScheduled($request);

	public function store($request);

	public function update($request, $slug);

	public function updateOnScheduleStore($request);

	public function updateOnScheduleUpdate($request);

	public function updateOnScheduleRollback($slug);

	public function updateStatus($slug, $int);

	public function updateDrop($request, $slug);

	public function updateResize($request, $slug);

	public function updateEventDrop($request, $slug);

	public function destroy($slug);

	public function findBySlug($slug);

	public function getUnscheduled();

	public function getScheduled();

	public function getByDate($df, $dt);

	public function countNew();
		
}