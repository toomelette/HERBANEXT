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





    // public function fetch($request){

    //     $key = str_slug($request->fullUrl(), '_');
    //     $entries = isset($request->e) ? $request->e : 20;

    //     $machine_mnt_list = $this->cache->remember('machine_mnt_list:fetch:' . $key, 240, function() use ($request, $entries){

    //         $machine_mnt = $this->machine_mnt->newQuery();
            
    //         if(isset($request->q)){
    //             $this->search($machine_mnt, $request->q);
    //         }

    //         return $this->populate($machine_mnt, $entries);

    //     });

    //     return $machine_mnt_list;

    // }





    // public function store($request){

    //     $machine_mnt = new MachineMaintenance;
    //     $machine_mnt->machine_mnt_id = $this->getMachineMaintenanceIdInc();
    //     $machine_mnt->slug = $this->str->random(16);
    //     $machine_mnt->name = $request->name;
    //     $machine_mnt->description = $request->description;
    //     $machine_mnt->created_at = $this->carbon->now();
    //     $machine_mnt->updated_at = $this->carbon->now();
    //     $machine_mnt->ip_created = request()->ip();
    //     $machine_mnt->ip_updated = request()->ip();
    //     $machine_mnt->user_created = $this->auth->user()->user_id;
    //     $machine_mnt->user_updated = $this->auth->user()->user_id;
    //     $machine_mnt->save();
        
    //     return $machine_mnt;

    // }





    // public function update($request, $slug){

    //     $machine_mnt = $this->findBySlug($slug);
    //     $machine_mnt->name = $request->name;
    //     $machine_mnt->description = $request->description;
    //     $machine_mnt->updated_at = $this->carbon->now();
    //     $machine_mnt->ip_updated = request()->ip();
    //     $machine_mnt->user_updated = $this->auth->user()->user_id;
    //     $machine_mnt->save();
        
    //     return $machine_mnt;

    // }





    // public function destroy($slug){

    //     $machine_mnt = $this->findBySlug($slug);
    //     $machine_mnt->delete();
    //     return $machine_mnt;

    // }





    // public function findBySlug($slug){

    //     $machine_mnt = $this->cache->remember('machine_mnt_list:findBySlug:' . $slug, 240, function() use ($slug){
    //         return $this->machine_mnt->where('slug', $slug)->first();
    //     }); 
        
    //     if(empty($machine_mnt)){
    //         abort(404);
    //     }

    //     return $machine_mnt;

    // }






    // // public function findByMachineMaintenanceId($machine_mnt_id){

    // //     $machine_mnt = $this->cache->remember('machine_mnt_list:findByMachineMaintenanceId:' . $machine_mnt_id, 240, function() use ($machine_mnt_id){
    // //         return $this->machine_mnt->where('machine_mnt_id', $machine_mnt_id)->first();
    // //     });
        
    // //     if(empty($machine_mnt)){
    // //         abort(404);
    // //     }
        
    // //     return $machine_mnt;

    // // }






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






    // public function getMachineMaintenanceIdInc(){

    //     $id = 'M10001';
    //     $machine_mnt = $this->machine_mnt->select('machine_mnt_id')->orderBy('machine_mnt_id', 'desc')->first();

    //     if($machine_mnt != null){
    //         if($machine_mnt->machine_mnt_id != null){
    //             $num = str_replace('M', '', $machine_mnt->machine_mnt_id) + 1;
    //             $id = 'M' . $num;
    //         }
    //     }
        
    //     return $id;
        
    // }






    // public function getAll(){

    //     $machine_mnt_list = $this->cache->remember('machine_mnt_list:getAll', 240, function(){
    //         return $this->machine_mnt->select('machine_mnt_id', 'name')->get();
    //     });
        
    //     return $machine_mnt_list;

    // }






}