<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\MachineInterface;

use App\Models\Machine;


class MachineRepository extends BaseRepository implements MachineInterface {
	


    protected $machine;



	public function __construct(Machine $machine){

        $this->machine = $machine;
        parent::__construct();

    }





    public function fetch($request){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $machines = $this->cache->remember('machines:fetch:' . $key, 240, function() use ($request, $entries){

            $machine = $this->machine->newQuery();
            
            if(isset($request->q)){
                $this->search($machine, $request->q);
            }

            return $this->populate($machine, $entries);

        });

        return $machines;

    }






    public function search($model, $key){

        return $model->where(function ($model) use ($key) {
                $model->where('name', 'LIKE', '%'. $key .'%')
                      ->orWhere('description', 'LIKE', '%'. $key .'%')
                      ->orWhere('code', 'LIKE', '%'. $key .'%');
        });

    }





    public function populate($model, $entries){

        return $model->select('machine_id', 'code', 'name', 'description', 'location', 'status', 'slug')
                     ->sortable()
                     ->orderBy('updated_at', 'desc')
                     ->paginate($entries);
    
    }





    public function store($request){

        $machine = new Machine;
        $machine->machine_id = $this->getMachineIdInc();
        $machine->slug = $this->str->random(16);
        $machine->name = $request->name;
        $machine->code = $request->code;
        $machine->location = $request->location;
        $machine->description = $request->description;
        $machine->status = 1;
        $machine->created_at = $this->carbon->now();
        $machine->updated_at = $this->carbon->now();
        $machine->ip_created = request()->ip();
        $machine->ip_updated = request()->ip();
        $machine->user_created = $this->auth->user()->user_id;
        $machine->user_updated = $this->auth->user()->user_id;
        $machine->save();
        
        return $machine;

    }





    public function update($request, $slug){

        $machine = $this->findBySlug($slug);
        $machine->name = $request->name;
        $machine->code = $request->code;
        $machine->location = $request->location;
        $machine->description = $request->description;
        $machine->updated_at = $this->carbon->now();
        $machine->ip_updated = request()->ip();
        $machine->user_updated = $this->auth->user()->user_id;
        $machine->save();
        
        return $machine;

    }





    public function updateStatus($request, $slug){

        $machine = $this->findBySlug($slug);
        $machine->status = $request->status;
        $machine->updated_at = $this->carbon->now();
        $machine->ip_updated = request()->ip();
        $machine->user_updated = $this->auth->user()->user_id;
        $machine->save();
        
        return $machine;

    }





    public function destroy($slug){

        $machine = $this->findBySlug($slug);
        $machine->delete();
        return $machine;

    }





    public function findBySlug($slug){

        $machine = $this->cache->remember('machines:findBySlug:' . $slug, 240, function() use ($slug){
            return $this->machine->where('slug', $slug)->first();
        }); 
        
        if(empty($machine)){
            abort(404);
        }

        return $machine;

    }






    public function getMachineIdInc(){

        $id = 'M10001';
        $machine = $this->machine->select('machine_id')->orderBy('machine_id', 'desc')->first();

        if($machine != null){
            if($machine->machine_id != null){
                $num = str_replace('M', '', $machine->machine_id) + 1;
                $id = 'M' . $num;
            }
        }
        
        return $id;
        
    }






    public function getAll(){

        $machines = $this->cache->remember('machines:getAll', 240, function(){
            return $this->machine->select('machine_id', 'name')
                                 ->get();
        });
        
        return $machines;

    }






}