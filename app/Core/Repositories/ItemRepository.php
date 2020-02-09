<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\ItemInterface;

use App\Models\Item;


class ItemRepository extends BaseRepository implements ItemInterface {
	


    protected $item;



	public function __construct(Item $item){

        $this->item = $item;
        parent::__construct();

    }





    public function fetch($request){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $items = $this->cache->remember('items:fetch:' . $key, 240, function() use ($request, $entries){

            $item = $this->item->newQuery();
            
            if(isset($request->q)){
                $this->search($item, $request->q);
            }

            return $this->populate($item, $entries);

        });

        return $items;

    }





    public function store($request){

        $item = new Item;
        $item->slug = $this->str->random(16);
        $item->product_code = $request->product_code;
        $item->name = $request->name;
        $item->description = $request->description;
        $item->unit_type_id = $request->unit_type_id;
        $item->quantity = $this->__dataType->string_to_num($request->quantity);
        $item->weight = $this->__dataType->string_to_num($request->weight);
        $item->weight_unit = $request->weight_unit;
        $item->volume = $this->__dataType->string_to_num($request->volume);
        $item->volume_unit = $request->volume_unit;
        $item->min_req_qty = $this->__dataType->string_to_num($request->min_req_qty);
        $item->price = $this->__dataType->string_to_num($request->price);
        $item->created_at = $this->carbon->now();
        $item->updated_at = $this->carbon->now();
        $item->ip_created = request()->ip();
        $item->ip_updated = request()->ip();
        $item->user_created = $this->auth->user()->user_id;
        $item->user_updated = $this->auth->user()->user_id;
        $item->save();
        
        return $item;

    }





    public function update($request, $slug){

        $item = $this->findBySlug($slug);
        $item->product_code = $request->product_code;
        $item->name = $request->name;
        $item->description = $request->description;
        $item->unit_type_id = $request->unit_type_id;
        $item->quantity = $this->__dataType->string_to_num($request->quantity);
        $item->weight = $this->__dataType->string_to_num($request->weight);
        $item->weight_unit = $request->weight_unit;
        $item->volume = $this->__dataType->string_to_num($request->volume);
        $item->volume_unit = $request->volume_unit;
        $item->min_req_qty = $this->__dataType->string_to_num($request->min_req_qty);
        $item->price = $this->__dataType->string_to_num($request->price);
        $item->updated_at = $this->carbon->now();
        $item->ip_updated = request()->ip();
        $item->user_updated = $this->auth->user()->user_id;
        $item->save();
        
        return $item;

    }





    public function destroy($slug){

        $item = $this->findBySlug($slug);
        $item->delete();

        return $item;

    }





    public function findBySlug($slug){

        $item = $this->cache->remember('items:findBySlug:' . $slug, 240, function() use ($slug){
            return $this->item->where('slug', $slug)->first();
        }); 
        
        if(empty($item)){
            abort(404);
        }

        return $item;

    }






    public function search($model, $key){

        return $model->where(function ($model) use ($key) {
                $model->where('product_code', 'LIKE', '%'. $key .'%')
                      ->orWhere('name', 'LIKE', '%'. $key .'%');
        });

    }





    public function populate($model, $entries){

        return $model->select('product_code', 'name', 'unit_type_id', 'quantity', 'weight', 'weight_unit', 'volume', 'volume_unit', 'price', 'min_req_qty', 'slug')
                     ->sortable()
                     ->orderBy('updated_at', 'desc')
                     ->paginate($entries);

    }








}