<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\MachineMaintenanceInterface;

use App\Models\MachineMaintenance;


class MachineMaintenanceRepository extends BaseRepository implements MachineMaintenanceInterface {
	

    protected $machine_mnt;


	public function __construct(MachineMaintenance $machine_mnt){

        $this->machine_mnt = $machine_mnt;
        parent::__construct();

    }




    public function fetchByMachineId($request, $machine_id){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $machine_maintenance = $this->cache->remember('machine_maintenance:fetchByMachineId:'.$machine_id.':'. $key, 240, 

            function() use ($request, $entries){

                $machine_mnt = $this->machine_mnt->newQuery();

                return $machine_mnt->select('date_from', 'time_from', 'date_to', 'time_to', 'description', 'slug')
                                   ->sortable()
                                   ->orderBy('date_from', 'desc')
                                   ->paginate($entries);

        });

        return $machine_maintenance;

    }





    public function store($request){

        $machine_mnt = new MachineMaintenance;
        $machine_mnt->slug = $this->str->random(16);
        $machine_mnt->machine_id = $request->machine_id;
        $machine_mnt->date_from = $this->__dataType->date_parse($request->date_from);
        $machine_mnt->time_from = $this->__dataType->time_parse($request->time_from);
        $machine_mnt->date_to = $this->__dataType->date_parse($request->date_to);
        $machine_mnt->time_to = $this->__dataType->time_parse($request->time_to);
        $machine_mnt->description = $request->description;
        $machine_mnt->created_at = $this->carbon->now();
        $machine_mnt->updated_at = $this->carbon->now();
        $machine_mnt->ip_created = request()->ip();
        $machine_mnt->ip_updated = request()->ip();
        $machine_mnt->user_created = $this->auth->user()->user_id;
        $machine_mnt->user_updated = $this->auth->user()->user_id;
        $machine_mnt->save();
        
        return $machine_mnt;

    }





    public function update($request, $slug){

        $machine_mnt = $this->findBySlug($slug);
        $machine_mnt->date_from = $this->__dataType->date_parse($request->e_date_from);
        $machine_mnt->time_from = $this->__dataType->time_parse($request->e_time_from);
        $machine_mnt->date_to = $this->__dataType->date_parse($request->e_date_to);
        $machine_mnt->time_to = $this->__dataType->time_parse($request->e_time_to);
        $machine_mnt->description = $request->e_description;
        $machine_mnt->updated_at = $this->carbon->now();
        $machine_mnt->ip_updated = request()->ip();
        $machine_mnt->user_updated = $this->auth->user()->user_id;
        $machine_mnt->save();
        
        return $machine_mnt;

    }





    public function destroy($slug){

        $machine_mnt = $this->findBySlug($slug);
        $machine_mnt->delete();
        return $machine_mnt;

    }





    public function findBySlug($slug){

        $machine_mnt = $this->cache->remember('machine_maintenance:findBySlug:' . $slug, 240, function() use ($slug){
            return $this->machine_mnt->where('slug', $slug)->first();
        }); 
        
        if(empty($machine_mnt)){
            abort(404);
        }

        return $machine_mnt;

    }





    public function getBySlug($slug){

        $machine_mnt = $this->cache->remember('machine_maintenance:getBySlug:' . $slug, 240, function() use ($slug){
            return $this->machine_mnt->where('slug', $slug)->get();
        }); 

        return $machine_mnt;

    }






}