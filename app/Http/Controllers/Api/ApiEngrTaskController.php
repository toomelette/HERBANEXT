<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Core\Interfaces\EngrTaskInterface;

use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;

class ApiEngrTaskController extends Controller{



	protected $engr_task_repo;
	protected $event;



	public function __construct(EngrTaskInterface $engr_task_repo, Dispatcher $event){
		$this->engr_task_repo = $engr_task_repo;
		$this->event = $event;
	}



	public function drop(Request $request, $slug){
    	if($request->Ajax()){
    		$engr_task = $this->engr_task_repo->updateDrop($request, $slug);
    		$this->event->fire('engr_task.drop', $engr_task);
	    }
    }



	public function resize(Request $request, $slug){
    	if($request->Ajax()){
    		$engr_task = $this->engr_task_repo->updateResize($request, $slug);
    		$this->event->fire('engr_task.resize', $engr_task);
	    }
    }



	public function eventDrop(Request $request, $slug){
    	if($request->Ajax()){
    		$engr_task = $this->engr_task_repo->updateEventDrop($request, $slug);
    		$this->event->fire('engr_task.event_drop', $engr_task);
	    }
    }


    
}
