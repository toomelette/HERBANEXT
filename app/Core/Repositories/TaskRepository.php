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





    public function fetch($request){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $tasks = $this->cache->remember('tasks:fetch:' . $key, 240, function() use ($request, $entries){

            $task = $this->task->newQuery();
            
            if(isset($request->q)){
                $this->search($task, $request->q);
            }
            
            if(isset($request->i)){
                $task->whereItemId($request->i);
            }
            
            if(isset($request->m)){
                $task->whereMachineId($request->m);
            }
            
            if(isset($request->s)){
                $task->whereStatus($request->s);
            }

            return $this->populate($task, $entries);

        });

        return $tasks;

    }






    public function search($model, $key){

        return $model->where(function ($model) use ($key) {
                $model->where('name', 'LIKE', '%'. $key .'%')
                      ->orWhere('description', 'LIKE', '%'. $key .'%')
                      ->orwhereHas('item', function ($model) use ($key) {
                        $model->where('name', 'LIKE', '%'. $key .'%');
                      })
                      ->orwhereHas('machine', function ($model) use ($key) {
                        $model->where('name', 'LIKE', '%'. $key .'%');
                      });
        });

    }





    public function populate($model, $entries){

        return $model->select('name', 'description', 'item_id', 'machine_id', 'status', 'date_from', 'date_to', 'created_at', 'slug')
                     ->sortable()
                     ->orderBy('updated_at', 'desc')
                     ->paginate($entries);
    
    }





    public function store($request){

        $task = new Task;
        $task->task_id = $this->getTaskIdInc();
        $task->slug = $this->str->random(16);
        $task->item_id = $request->item_id;
        $task->machine_id = $request->machine_id;
        $task->name = $request->name;
        $task->description = $request->description;
        $task->date_from = $this->__dataType->date_parse($request->date_from .''. $request->time_from, 'Y-m-d H:i:s');
        $task->date_to = $this->__dataType->date_parse($request->date_to .''. $request->time_to, 'Y-m-d H:i:s');
        $task->status = 2;
        $task->is_allday = 0;
        $task->created_at = $this->carbon->now();
        $task->updated_at = $this->carbon->now();
        $task->ip_created = request()->ip();
        $task->ip_updated = request()->ip();
        $task->user_created = $this->auth->user()->user_id;
        $task->user_updated = $this->auth->user()->user_id;
        $task->save();
        
        return $task;

    }





    public function update($request, $slug){

        $task = $this->findBySlug($slug);
        $task->item_id = $request->item_id;
        $task->machine_id = $request->machine_id;
        $task->name = $request->name;
        $task->description = $request->description;
        $task->date_from = $this->__dataType->date_parse($request->date_from .''. $request->time_from, 'Y-m-d H:i:s');
        $task->date_to = $this->__dataType->date_parse($request->date_to .''. $request->time_to, 'Y-m-d H:i:s');
        $task->updated_at = $this->carbon->now();
        $task->ip_updated = request()->ip();
        $task->user_updated = $this->auth->user()->user_id;
        $task->save();
        $task->taskPersonnel()->delete();
        
        return $task;

    }





    public function updateStatus($slug, $int){

        $task = $this->findBySlug($slug);
        $task->status = $int;
        $task->updated_at = $this->carbon->now();
        $task->ip_updated = request()->ip();
        $task->user_updated = $this->auth->user()->user_id;
        
        $task->save();
        
        return $task;

    }





    public function destroy($slug){

        $task = $this->findBySlug($slug);
        $task->delete();
        $task->taskPersonnel()->delete();
        return $task;

    }





    public function findBySlug($slug){

        $task = $this->cache->remember('tasks:findBySlug:' . $slug, 240, function() use ($slug){
            return $this->task->where('slug', $slug)
                              ->with('taskPersonnel')           
                              ->first();
        }); 
        
        if(empty($task)){
            abort(404);
        }

        return $task;

    }






    public function getScheduled(){

        $tasks = $this->cache->remember('tasks:getScheduled', 240, function(){
            return $this->task->select('task_id', 'machine_id', 'slug', 'name', 'description', 'is_allday', 'date_from', 'date_to', 'color')
                              ->with('taskPersonnel')
                              ->whereIn('status', [2,3])
                              ->get();
        });
        
        return $tasks;

    }





    public function getByDate($df, $dt){

        $tasks = $this->cache->remember('tasks:getByDate:'.$df.'-'.$dt, 240, function() use ($df, $dt){
            
            $task = $this->task->newQuery();
            $date_from = $this->__dataType->date_parse($df, 'Y-m-d 00:00:00');
            $date_to = $this->__dataType->date_parse($dt, 'Y-m-d 24:00:00');

            if(isset($df) || isset($dt)){
                $task->where('date_from', '>=', $df)->where('date_from', '<=', $dt);
            }

            return $task->select('task_id', 'machine_id', 'name', 'description', 'date_from', 'date_to')
                        ->with('taskPersonnel')
                        ->get();
        
        });
        
        return $tasks;

    }




    public function countNew(){

        $tasks = $this->cache->remember('tasks:countNew', 240, function(){
            $date_now = $this->carbon->now()->format('Y-m-d');
            return $this->task->whereDate('created_at', $date_now)->count();
        }); 

        return $tasks;

    }




    public function getTaskIdInc(){

        $id = 'T10001';
        $task = $this->task->select('task_id')->orderBy('task_id', 'desc')->first();

        if($task != null){
            if($task->task_id != null){
                $num = str_replace('T', '', $task->task_id) + 1;
                $id = 'T' . $num;
            }
        }
        
        return $id;
        
    }






}