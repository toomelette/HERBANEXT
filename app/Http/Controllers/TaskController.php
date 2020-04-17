<?php

namespace App\Http\Controllers;


use App\Core\Services\TaskService;
use App\Http\Requests\Task\TaskFormRequest;
use App\Http\Requests\Task\TaskFilterRequest;


class TaskController extends Controller{


    protected $task;


    public function __construct(TaskService $task){
        $this->task = $task;
    }

    
    public function index(TaskFilterRequest $request){
        return $this->task->fetch($request);
    }

    
    public function scheduling(){
        return $this->task->scheduling();
    }

    
    public function create(){
        return view('dashboard.task.create');
    }

   
    public function store(TaskFormRequest $request){
        return $this->task->store($request);
    }
 

    public function edit($slug){
        return $this->task->edit($slug);
    }


    public function update(TaskFormRequest $request, $slug){
        return $this->task->update($request, $slug);
    }

    
    public function destroy($slug){
        return $this->task->destroy($slug);
    }



    
}
