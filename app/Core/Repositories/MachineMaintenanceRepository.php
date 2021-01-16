<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\MachineMaintenanceInterface;

use App\Models\MachineMaintenance;


class MachineMaintenanceRepository extends BaseRepository implements MachineMaintenanceInterface {
	


    protected $machine_maintenance;



	public function __construct(MachineMaintenance $machine_maintenance){

        $this->machine_maintenance = $machine_maintenance;
        parent::__construct();

    }





    public function fetch($request){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $machine_maintenances = $this->cache->remember('machine_maintenances:fetch:' . $key, 240, function() use ($request, $entries){

            $machine_maintenance = $this->machine_maintenance->newQuery();
            
            if(isset($request->q)){
                $this->search($machine_maintenance, $request->q);
            }

            return $this->populate($machine_maintenance, $entries);

        });

        return $machine_maintenances;

    }






    public function search($model, $key){

        return $model->where(function ($model) use ($key) {
                $model->where('description', 'LIKE', '%'. $key .'%')
                      ->orwhereHas('machine', function ($model) use ($key) {
                          $model->where('name', 'LIKE', '%'. $key .'%');
                      });;
        });

    }





    public function populate($model, $entries){

        return $model->select('slug', 'machine_id', 'date_from', 'date_to', 'time_from', 'time_to', 'description', 'remarks')
                     ->with('machine')
                     ->sortable()
                     ->orderBy('updated_at', 'desc')
                     ->paginate($entries);
    
    }





    public function store($request){

        $machine_maintenance = new MachineMaintenance;
        $machine_maintenance->slug = $this->str->random(16);
        $machine_maintenance->machine_id = $request->machine_id;
        $machine_maintenance->description = $request->description;
        $machine_maintenance->date_from =  $this->__dataType->date_parse($request->date_from);
        $machine_maintenance->date_to =  $this->__dataType->date_parse($request->date_to);
        $machine_maintenance->time_from = $this->__dataType->time_parse($request->time_from);
        $machine_maintenance->time_to = $this->__dataType->time_parse($request->time_to);
        $machine_maintenance->remarks = $request->remarks;
        $machine_maintenance->created_at = $this->carbon->now();
        $machine_maintenance->updated_at = $this->carbon->now();
        $machine_maintenance->ip_created = request()->ip();
        $machine_maintenance->ip_updated = request()->ip();
        $machine_maintenance->user_created = $this->auth->user()->user_id;
        $machine_maintenance->user_updated = $this->auth->user()->user_id;
        $machine_maintenance->save();
        
        return $machine_maintenance;

    }





    public function update($request, $slug){

        $machine_maintenance = $this->findBySlug($slug);
        $machine_maintenance->machine_id = $request->e_machine_id;
        $machine_maintenance->description = $request->e_description;
        $machine_maintenance->date_from =  $this->__dataType->date_parse($request->e_date_from);
        $machine_maintenance->date_to =  $this->__dataType->date_parse($request->e_date_to);
        $machine_maintenance->time_from = $this->__dataType->time_parse($request->e_time_from);
        $machine_maintenance->time_to = $this->__dataType->time_parse($request->e_time_to);
        $machine_maintenance->remarks = $request->e_remarks;
        $machine_maintenance->updated_at = $this->carbon->now();
        $machine_maintenance->ip_updated = request()->ip();
        $machine_maintenance->user_updated = $this->auth->user()->user_id;
        $machine_maintenance->save();
        
        return $machine_maintenance;

    }





    public function destroy($slug){

        $machine_maintenance = $this->findBySlug($slug);
        $machine_maintenance->delete();
        return $machine_maintenance;

    }





    public function findBySlug($slug){

        $machine_maintenance = $this->cache->remember('machine_maintenances:findBySlug:' . $slug, 240, function() use ($slug){
            return $this->machine_maintenance->where('slug', $slug)->first();
        }); 
        
        if(empty($machine_maintenance)){
            abort(404);
        }

        return $machine_maintenance;

    }






    public function getAll(){

        $tasks = $this->cache->remember('machine_maintenances:getAll', 240, function(){
            return $this->machine_maintenance->select('machine_id', 'date_from', 'date_to', 'time_from', 'time_to', 'description', 'remarks')
                                             ->with('machine')
                                             ->get();
        });
        
        return $tasks;

    }






}