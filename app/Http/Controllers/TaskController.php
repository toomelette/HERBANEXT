<?php

namespace App\Http\Controllers;


use App\Core\Services\TaskService;
use App\Http\Requests\Task\TaskFormRequest;
use App\Http\Requests\Task\TaskFilterRequest;
use App\Http\Requests\Task\TaskRatePersonnelFormRequest;
use App\Http\Requests\Task\TaskReportFormRequest;
use App\Http\Requests\Task\TaskSchedulingFilterRequest;
use App\Http\Requests\Task\TaskSchedulingStoreFormRequest;
use App\Http\Requests\Task\TaskSchedulingUpdateFormRequest;


class TaskController extends Controller{


    protected $task;


    public function __construct(TaskService $task){
        $this->task = $task;
    }

    
    public function index(TaskFilterRequest $request){
        return $this->task->fetch($request);
    }

    
    public function schedulingIndex(TaskSchedulingFilterRequest $request){
        return $this->task->schedulingIndex($request);
    }

    
    public function schedulingStore(TaskSchedulingStoreFormRequest $request){
        return $this->task->schedulingStore($request);
    }

    
    public function schedulingUpdate(TaskSchedulingUpdateFormRequest $request){
        return $this->task->schedulingUpdate($request);
    }

    
    public function schedulingRollback($slug){
        return $this->task->schedulingRollback($slug);
    }

    
    public function calendar(){
        return $this->task->calendar();
    }

    
    public function updateFinished($slug){
        return $this->task->updateFinished($slug);
    }

    
    public function updateUnfinished($slug){
        return $this->task->updateUnfinished($slug);
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

    
    public function ratePersonnel($slug){
        return $this->task->ratePersonnel($slug);
    }

    
    public function ratePersonnelPost(TaskRatePersonnelFormRequest $request, $task_personnel_id){
        return $this->task->ratePersonnelPost($request, $task_personnel_id);
    }

    
    public function reports(){
        return view('dashboard.task.reports');
    }

    
    public function reportsOutput(TaskReportFormRequest $request){

        return $this->task->reportsOutput($request);

    }



    
}
