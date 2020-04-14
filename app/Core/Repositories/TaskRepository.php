<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\TaskInterface;

use App\Models\Task;


class TaskRepository extends BaseRepository implements TaskInterface {
	


    protected $task;



	public function __construct(Task $task){

        $this->task = $task;
        parent::__construct();

    }





    // public function fetch($request){

    //     $key = str_slug($request->fullUrl(), '_');
    //     $entries = isset($request->e) ? $request->e : 20;

    //     $tasks = $this->cache->remember('tasks:fetch:' . $key, 240, function() use ($request, $entries){

    //         $task = $this->task->newQuery();
            
    //         if(isset($request->q)){
    //             $this->search($task, $request->q);
    //         }

    //         return $this->populate($task, $entries);

    //     });

    //     return $tasks;

    // }





    // public function store($request){

    //     $task = new Task;
    //     $task->task_id = $this->getTaskIdInc();
    //     $task->slug = $this->str->random(16);
    //     $task->name = $request->name;
    //     $task->description = $request->description;
    //     $task->created_at = $this->carbon->now();
    //     $task->updated_at = $this->carbon->now();
    //     $task->ip_created = request()->ip();
    //     $task->ip_updated = request()->ip();
    //     $task->user_created = $this->auth->user()->user_id;
    //     $task->user_updated = $this->auth->user()->user_id;
    //     $task->save();
        
    //     return $task;

    // }





    // public function update($request, $slug){

    //     $task = $this->findBySlug($slug);
    //     $task->name = $request->name;
    //     $task->description = $request->description;
    //     $task->updated_at = $this->carbon->now();
    //     $task->ip_updated = request()->ip();
    //     $task->user_updated = $this->auth->user()->user_id;
    //     $task->save();
        
    //     return $task;

    // }





    // public function destroy($slug){

    //     $task = $this->findBySlug($slug);
    //     $task->delete();
    //     return $task;

    // }





    // public function findBySlug($slug){

    //     $task = $this->cache->remember('tasks:findBySlug:' . $slug, 240, function() use ($slug){
    //         return $this->task->where('slug', $slug)->first();
    //     }); 
        
    //     if(empty($task)){
    //         abort(404);
    //     }

    //     return $task;

    // }






    // public function findByTaskId($task_id){

    //     $task = $this->cache->remember('tasks:findByTaskId:' . $task_id, 240, function() use ($task_id){
    //         return $this->task->where('task_id', $task_id)->first();
    //     });
        
    //     if(empty($task)){
    //         abort(404);
    //     }
        
    //     return $task;

    // }






    // public function search($model, $key){

    //     return $model->where(function ($model) use ($key) {
    //             $model->where('name', 'LIKE', '%'. $key .'%')
    //                   ->orWhere('description', 'LIKE', '%'. $key .'%');
    //     });

    // }





    // public function populate($model, $entries){

    //     return $model->select('name', 'description', 'slug')
    //                  ->sortable()
    //                  ->orderBy('updated_at', 'desc')
    //                  ->paginate($entries);
    
    // }






    // public function getTaskIdInc(){

    //     $id = 'M10001';
    //     $task = $this->task->select('task_id')->orderBy('task_id', 'desc')->first();

    //     if($task != null){
    //         if($task->task_id != null){
    //             $num = str_replace('M', '', $task->task_id) + 1;
    //             $id = 'M' . $num;
    //         }
    //     }
        
    //     return $id;
        
    // }






    // public function getAll(){

    //     $tasks = $this->cache->remember('tasks:getAll', 240, function(){
    //         return $this->task->select('task_id', 'name')->get();
    //     });
        
    //     return $tasks;

    // }






}