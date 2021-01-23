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
            
            if(isset($request->t)){
                $engr_task->whereCat($request->t);
            }
            
            if(isset($request->s)){
                $engr_task->whereStatus($request->s);
            }

            return $this->populate($engr_task, $entries);

        });

        return $engr_tasks;

    }






    public function search($model, $key){

        return $model->where(function ($model) use ($key) {
                $model->where('name', 'LIKE', '%'. $key .'%')
                      ->orWhere('jo_no', 'LIKE', '%'. $key .'%')
                      ->orWhere('requested_by', 'LIKE', '%'. $key .'%')
                      ->orWhere('unit', 'LIKE', '%'. $key .'%')
                      ->orWhere('location', 'LIKE', '%'. $key .'%')
                      ->orWhere('description', 'LIKE', '%'. $key .'%')
                      ->orWhere('pic', 'LIKE', '%'. $key .'%');
        });

    }





    public function populate($model, $entries){

        return $model->select('name', 'jo_no', 'description', 'location', 'cat', 'status', 'date_from', 'date_to', 'created_at', 'slug')
                     ->sortable()
                     ->orderBy('updated_at', 'desc')
                     ->paginate($entries);
    
    }





    public function store($request){

        $engr_task = new EngrTask;
        $engr_task->engr_task_id = $this->getEngrTaskIdInc();
        $engr_task->slug = $this->str->random(16);
        $engr_task->jo_no = $request->jo_no;
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

        $engr_task->date_from = $this->__dataType->date_parse($request->date_from .''. $request->time_from, 'Y-m-d H:i:s');
        $engr_task->date_to = $this->__dataType->date_parse($request->date_to .''. $request->time_to, 'Y-m-d H:i:s');
        $engr_task->status = 2;
        $engr_task->is_allday = 0;

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
        $engr_task->jo_no = $request->jo_no;
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

        $engr_task->date_from = $this->__dataType->date_parse($request->date_from .''. $request->time_from, 'Y-m-d H:i:s');
        $engr_task->date_to = $this->__dataType->date_parse($request->date_to .''. $request->time_to, 'Y-m-d H:i:s');

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






    public function getScheduled(){

        $engr_tasks = $this->cache->remember('engr_tasks:getScheduled', 240, function(){
            return $this->engr_task->select('engr_task_id', 'slug', 'name', 'description', 'is_allday', 'date_from', 'date_to', 'color')
                              ->with('engrTaskPersonnel')
                              ->whereIn('status', [2,3])
                              ->get();
        });
        
        return $engr_tasks;

    }






}