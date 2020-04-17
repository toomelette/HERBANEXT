<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Core\Interfaces\TaskInterface;

use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;

class ApiTaskController extends Controller{



	protected $task_repo;
	protected $event;



	public function __construct(TaskInterface $task_repo, Dispatcher $event){
		$this->task_repo = $task_repo;
		$this->event = $event;
	}



	public function drop(Request $request, $slug){
    	if($request->Ajax()){
    		$task = $this->task_repo->updateDrop($request, $slug);
    		$this->event->fire('task.drop', $task);
	    }
    }



	public function resize(Request $request, $slug){
    	if($request->Ajax()){
    		$task = $this->task_repo->updateResize($request, $slug);
    		$this->event->fire('task.resize', $task);
	    }
    }



	public function eventDrop(Request $request, $slug){
    	if($request->Ajax()){
    		$task = $this->task_repo->updateEventDrop($request, $slug);
    		$this->event->fire('task.event_drop', $task);
	    }
    }


    
}
