<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\ItemTypeInterface;

use App\Models\ItemType;


class ItemTypeRepository extends BaseRepository implements ItemTypeInterface {
	


    protected $item_type;



	public function __construct(ItemType $item_type){

        $this->item_type = $item_type;
        parent::__construct();

    }





    public function fetch($request){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $item_types = $this->cache->remember('item_types:fetch:' . $key, 240, function() use ($request, $entries){

            $item_type = $this->item_type->newQuery();
            
            if(isset($request->q)){
                $this->search($item_type, $request->q);
            }

            return $this->populate($item_type, $entries);

        });

        return $item_types;

    }





    public function store($request){

        $item_type = new ItemType;
        $item_type->slug = $this->str->random(16);
        $item_type->item_type_id = $this->getItemTypeIdInc();
        $item_type->name = $request->name;
        $item_type->percent = $this->__dataType->string_to_num($request->percent);
        $item_type->created_at = $this->carbon->now();
        $item_type->updated_at = $this->carbon->now();
        $item_type->ip_created = request()->ip();
        $item_type->ip_updated = request()->ip();
        $item_type->user_created = $this->auth->user()->user_id;
        $item_type->user_updated = $this->auth->user()->user_id;
        $item_type->save();
        
        return $item_type;

    }





    public function update($request, $slug){

        $item_type = $this->findBySlug($slug);
        $item_type->name = $request->name;
        $item_type->percent = $this->__dataType->string_to_num($request->percent);
        $item_type->updated_at = $this->carbon->now();
        $item_type->ip_updated = request()->ip();
        $item_type->user_updated = $this->auth->user()->user_id;
        $item_type->save();
        
        return $item_type;

    }





    public function destroy($slug){

        $item_type = $this->findBySlug($slug);
        $item_type->delete();

        return $item_type;

    }





    public function findBySlug($slug){

        $item_type = $this->cache->remember('item_types:findBySlug:' . $slug, 240, function() use ($slug){
            return $this->item_type->where('slug', $slug)->first();
        }); 
        
        if(empty($item_type)){
            abort(404);
        }

        return $item_type;

    }






    public function search($model, $key){

        return $model->where(function ($model) use ($key) {
                $model->where('name', 'LIKE', '%'. $key .'%');
        });

    }





    public function populate($model, $entries){

        return $model->select('name', 'percent', 'slug')
                     ->sortable()
                     ->orderBy('updated_at', 'desc')
                     ->paginate($entries);

    }






    public function getItemTypeIdInc(){

        $id = 'IT1001';

        $item_type = $this->item_type->select('item_type_id')->orderBy('item_type_id', 'desc')->first();

        if($item_type != null){

            if($item_type->item_type_id != null){
                $num = str_replace('IT', '', $item_type->item_type_id) + 1;
                $id = 'IT' . $num;
            }
        
        }
        
        return $id;
        
    }






    public function getAll(){

        $item_types = $this->cache->remember('item_types:getAll', 240, function(){
            return $this->item_type->select('item_type_id', 'name')->get();
        });
        
        return $item_types;

    }








}