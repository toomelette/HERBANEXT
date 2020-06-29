<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\EngrTaskInterface;

use App\Models\EngrTask;


class EngrTaskRepository extends BaseRepository implements EngrTaskInterface {
	


    protected $engr_task;



	public function __construct(EngrTask $engr_task){

        $this->engr_task = $engr_task;
        parent::__construct();

    }





    public function fetch($request){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $engr_tasks = $this->cache->remember('engr_tasks:fetch:' . $key, 240, function() use ($request, $entries){

            $engr_task = $this->engr_task->newQuery();
            
            if(isset($request->q)){
                $this->search($engr_task, $request->q);
            }

            return $this->populate($engr_task, $entries);

        });

        return $engr_tasks;

    }





    public function store($request){

        $engr_task = new EngrTask;
        $engr_task->engr_task_id = $this->getEngrTaskIdInc();
        $engr_task->slug = $this->str->random(16);
        $engr_task->cat = $request->cat;
        $engr_task->name = $request->name;
        $engr_task->requested_by = $request->requested_by;
        $engr_task->unit = $request->unit;
        $engr_task->location = $request->location;
        $engr_task->description = $request->description;
        $engr_task->pic = $request->pic;
        
        if ($request->cat == 'JO') {
            $engr_task->color = '#0073b7'; 
        }elseif ($request->cat == 'DA') {
            $engr_task->color = '#ff851b';
        }

        $engr_task->created_at = $this->carbon->now();
        $engr_task->updated_at = $this->carbon->now();
        $engr_task->ip_created = request()->ip();
        $engr_task->ip_updated = request()->ip();
        $engr_task->user_created = $this->auth->user()->user_id;
        $engr_task->user_updated = $this->auth->user()->user_id;
        $engr_task->save();
        
        return $engr_task;

    }





    public function update($request, $slug){

        $engr_task = $this->findBySlug($slug);
        $engr_task->name = $request->name;
        $engr_task->requested_by = $request->requested_by;
        $engr_task->unit = $request->unit;
        $engr_task->location = $request->location;
        $engr_task->description = $request->description;
        $engr_task->pic = $request->pic;
        
        if ($request->cat == 'JO') {
            $engr_task->color = '#0073b7'; 
        }elseif ($request->cat == 'DA') {
            $engr_task->color = '#ff851b';
        }

        $engr_task->updated_at = $this->carbon->now();
        $engr_task->ip_updated = request()->ip();
        $engr_task->user_updated = $this->auth->user()->user_id;
        $engr_task->save();
        $engr_task->engrTaskPersonnel()->delete();
        
        return $engr_task;

    }





    public function destroy($slug){

        $engr_task = $this->findBySlug($slug);
        $engr_task->delete();
        $engr_task->engrTaskPersonnel()->delete();
        return $engr_task;

    }





    public function updateStatus($slug, $int){

        $engr_task = $this->findBySlug($slug);
        $engr_task->status = $int;
        $engr_task->updated_at = $this->carbon->now();
        $engr_task->ip_updated = request()->ip();
        $engr_task->user_updated = $this->auth->user()->user_id;
        $engr_task->save();
        
        return $engr_task;

    }





    public function updateDrop($request, $slug){

        $engr_task = $this->findBySlug($slug);
        $engr_task->date_from = $this->__dataType->date_parse($request->date);
        $engr_task->date_to = $this->__dataType->date_parse($request->date);
        $engr_task->is_allday = 1;
        $engr_task->status = 2;
        $engr_task->save();
        
        return $engr_task;

    }





    public function updateResize($request, $slug){

        $engr_task = $this->findBySlug($slug);
        $engr_task->date_from = $this->__dataType->date_parse($request->start_date, 'Y-m-d H:i:s');
        $engr_task->date_to = $this->__dataType->date_parse($request->end_date, 'Y-m-d H:i:s');
        $engr_task->is_allday =  $this->__dataType->string_to_boolean($request->allday);
        $engr_task->save();
        
        return $engr_task;

    }





    public function updateEventDrop($request, $slug){

        $engr_task = $this->findBySlug($slug);
        $engr_task->date_from = $this->__dataType->date_parse($request->start_date, 'Y-m-d H:i:s');
        $engr_task->date_to = $this->__dataType->date_parse($request->end_date, 'Y-m-d H:i:s');
        $engr_task->is_allday = $this->__dataType->string_to_boolean($request->allday);
        $engr_task->save();
        
        return $engr_task;

    }





    public function findBySlug($slug){

        $engr_task = $this->cache->remember('engr_tasks:findBySlug:' . $slug, 240, function() use ($slug){
            return $this->engr_task->where('slug', $slug)
                                   ->with('engrTaskPersonnel')           
                                   ->first();
        }); 
        
        if(empty($engr_task)){
            abort(404);
        }

        return $engr_task;

    }






    public function search($model, $key){

        return $model->where(function ($model) use ($key) {
                $model->where('name', 'LIKE', '%'. $key .'%')
                      ->orWhere('requested_by', 'LIKE', '%'. $key .'%')
                      ->orWhere('unit', 'LIKE', '%'. $key .'%')
                      ->orWhere('location', 'LIKE', '%'. $key .'%')
                      ->orWhere('description', 'LIKE', '%'. $key .'%')
                      ->orWhere('pic', 'LIKE', '%'. $key .'%');
        });

    }





    public function populate($model, $entries){

        return $model->select('name', 'description', 'location', 'cat', 'status', 'created_at', 'updated_at', 'slug')
                     ->sortable()
                     ->orderBy('updated_at', 'desc')
                     ->paginate($entries);
    
    }






    public function getEngrTaskIdInc(){

        $id = 'ET10001';
        $engr_task = $this->engr_task->select('engr_task_id')->orderBy('engr_task_id', 'desc')->first();

        if($engr_task != null){
            if($engr_task->engr_task_id != null){
                $num = str_replace('ET', '', $engr_task->engr_task_id) + 1;
                $id = 'ET' . $num;
            }
        }
        
        return $id;
        
    }






    public function getUnscheduledJO(){

        $engr_tasks = $this->cache->remember('engr_tasks:getUnscheduledJO', 240, function(){
            return $this->engr_task->select('slug', 'name', 'color')
                                   ->where('cat', 'JO')
                                   ->where('status', 1)
                                   ->get();
        });
        
        return $engr_tasks;

    }






    public function getUnscheduledDA(){

        $engr_tasks = $this->cache->remember('engr_tasks:getUnscheduledDA', 240, function(){
            return $this->engr_task->select('slug', 'name', 'color')
                                   ->where('cat', 'DA')
                                   ->where('status', 1)
                                   ->get();
        });
        
        return $engr_tasks;

    }






    public function getScheduled(){

        $engr_tasks = $this->cache->remember('engr_tasks:getScheduled', 240, function(){
            return $this->engr_task->select('slug', 'name', 'description', 'is_allday', 'date_from', 'date_to', 'color')
                              ->whereIn('status', [2,3])
                              ->get();
        });
        
        return $engr_tasks;

    }



    // public function countNew(){

    //     $engr_tasks = $this->cache->remember('engr_tasks:countNew', 240, function(){

    //         $date_now = $this->carbon->now()->format('Y-m-d');

    //         return $this->engr_task->whereDate('created_at', $date_now)->count();
        
    //     }); 

    //     return $engr_tasks;

    // }






}