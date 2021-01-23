<?php

namespace App\Http\Controllers;


use App\Core\Services\EngrTaskService;
use App\Http\Requests\EngrTask\EngrTaskFormRequest;
use App\Http\Requests\EngrTask\EngrTaskFilterRequest;
use App\Http\Requests\EngrTask\EngrTaskRatePersonnelFormRequest;


class EngrTaskController extends Controller{


    protected $engr_task;


    public function __construct(EngrTaskService $engr_task){
        $this->engr_task = $engr_task;
    }

    
    public function index(EngrTaskFilterRequest $request){
        return $this->engr_task->fetch($request);
    }

    
    public function calendar(){
        return $this->engr_task->calendar();
    }

    
    public function updateFinished($slug){
        return $this->engr_task->updateFinished($slug);
    }

    
    public function updateUnfinished($slug){
        return $this->engr_task->updateUnfinished($slug);
    }

    
    public function createJO(){
        return view('dashboard.engr_task.create_jo');
    }

    
    public function createDA(){
        return view('dashboard.engr_task.create_da');
    }

   
    public function store(EngrTaskFormRequest $request){
        return $this->engr_task->store($request);
    }
 

    public function edit($slug){
        return $this->engr_task->edit($slug);
    }


    public function update(EngrTaskFormRequest $request, $slug){
        return $this->engr_task->update($request, $slug);
    }

    
    public function destroy($slug){
        return $this->engr_task->destroy($slug);
    }

    
    public function ratePersonnel($slug){
        return $this->engr_task->ratePersonnel($slug);
    }

    
    public function ratePersonnelPost(EngrTaskRatePersonnelFormRequest $request, $engr_task_personnel_id){
        return $this->engr_task->ratePersonnelPost($request, $engr_task_personnel_id);
    }



    
}
