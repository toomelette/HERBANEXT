<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\PersonnelInterface;

use App\Models\Personnel;


class PersonnelRepository extends BaseRepository implements PersonnelInterface {
	


    protected $personnel;



	public function __construct(Personnel $personnel){

        $this->personnel = $personnel;
        parent::__construct();

    }





    public function fetch($request){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $personnels = $this->cache->remember('personnels:fetch:' . $key, 240, function() use ($request, $entries){

            $personnel = $this->personnel->newQuery();
            
            if(isset($request->q)){
                $this->search($personnel, $request->q);
            }

            return $this->populate($personnel, $entries);

        });

        return $personnels;

    }





    public function store($request, $img_location){

        $personnel = new Personnel;
        $personnel->personnel_id = $this->getPersonnelIdInc();
        $personnel->slug = $this->str->random(16);
        $personnel->avatar_location = $img_location;
        $personnel->firstname = $request->firstname;
        $personnel->middlename = $request->middlename;
        $personnel->lastname = $request->lastname;
        $personnel->position = $request->position;
        $personnel->contact_no = $request->contact_no;
        $personnel->email = $request->email;
        $personnel->created_at = $this->carbon->now();
        $personnel->updated_at = $this->carbon->now();
        $personnel->ip_created = request()->ip();
        $personnel->ip_updated = request()->ip();
        $personnel->user_created = $this->auth->user()->user_id;
        $personnel->user_updated = $this->auth->user()->user_id;
        $personnel->save();
        
        return $personnel;

    }





    public function update($request, $slug, $img_location){

        $personnel = $this->findBySlug($slug);
        $personnel->avatar_location = $img_location;
        $personnel->firstname = $request->firstname;
        $personnel->middlename = $request->middlename;
        $personnel->lastname = $request->lastname;
        $personnel->position = $request->position;
        $personnel->contact_no = $request->contact_no;
        $personnel->email = $request->email;
        $personnel->updated_at = $this->carbon->now();
        $personnel->ip_updated = request()->ip();
        $personnel->user_updated = $this->auth->user()->user_id;
        $personnel->save();
        
        return $personnel;

    }





    public function destroy($slug){

        $personnel = $this->findBySlug($slug);
        $personnel->delete();
        return $personnel;

    }





    public function findBySlug($slug){

        $personnel = $this->cache->remember('personnels:findBySlug:' . $slug, 240, function() use ($slug){
            return $this->personnel->where('slug', $slug)->first();
        }); 
        
        if(empty($personnel)){
            abort(404);
        }

        return $personnel;

    }






    public function search($model, $key){

        return $model->where(function ($model) use ($key) {
                $model->where('firstname', 'LIKE', '%'. $key .'%')
                      ->orWhere('middlename', 'LIKE', '%'. $key .'%')
                      ->orWhere('lastname', 'LIKE', '%'. $key .'%')
                      ->orWhere('position', 'LIKE', '%'. $key .'%')
                      ->orWhere('contact_no', 'LIKE', '%'. $key .'%')
                      ->orWhere('email', 'LIKE', '%'. $key .'%');
        });

    }





    public function populate($model, $entries){

        return $model->select('personnel_id', 'firstname', 'middlename', 'lastname', 'position', 'slug')                     
                     ->sortable()
                     ->orderBy('updated_at', 'desc')
                     ->paginate($entries);
    
    }






    public function getPersonnelIdInc(){

        $id = 'P10001';
        $personnel = $this->personnel->select('personnel_id')->orderBy('personnel_id', 'desc')->first();

        if($personnel != null){
            if($personnel->personnel_id != null){
                $num = str_replace('P', '', $personnel->personnel_id) + 1;
                $id = 'P' . $num;
            }
        }
        
        return $id;
        
    }






    public function getAll(){

        $personnels = $this->cache->remember('personnels:getAll', 240, function(){
            return $this->personnel->select('personnel_id', 'firstname', 'middlename', 'lastname')
                                   ->get();
        });
        
        return $personnels;

    }






}