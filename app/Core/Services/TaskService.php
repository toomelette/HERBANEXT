<?php
 
namespace App\Core\Services;


use App\Core\Interfaces\TaskInterface;
use App\Core\Interfaces\TaskPersonnelInterface;
use App\Core\BaseClasses\BaseService;


class TaskService extends BaseService{



    protected $task_repo;
    protected $task_personnel_repo;



    public function __construct(TaskInterface $task_repo, TaskPersonnelInterface $task_personnel_repo){

        $this->task_repo = $task_repo;
        $this->task_personnel_repo = $task_personnel_repo;
        parent::__construct();

    }



    public function fetch($request){

        $tasks = $this->task_repo->fetch($request);
        $request->flash();
        return view('dashboard.task.index')->with('tasks', $tasks);

    }



    public function store($request){    

        $task = $this->task_repo->store($request);

        if(!empty($request->personnels)){
            foreach ($request->personnels as $data) {
                $this->task_personnel_repo->store($task->task_id, $data);
            }
        }

        $this->event->fire('task.store');
        return redirect()->back();

    }



    public function edit($slug){

        $task = $this->task_repo->findbySlug($slug);
        return view('dashboard.task.edit')->with('task', $task);

    }



    public function update($request, $slug){

        $task = $this->task_repo->update($request, $slug);

        if(!empty($request->personnels)){
            foreach ($request->personnels as $data) {
                $this->task_personnel_repo->store($task->task_id, $data);
            }
        }
        
        $this->event->fire('task.update', $task);
        return redirect()->route('dashboard.task.index');

    }



    public function destroy($slug){

        $task = $this->task_repo->destroy($slug);
        $this->event->fire('task.destroy', $task);
        return redirect()->back();

    }




}