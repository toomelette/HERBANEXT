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
            
            if(isset($request->cat)){
                $item->whereItemCategoryId($request->cat);
            }
            
            if(isset($request->s)){
                $item->whereSupplierId($request->s);
            }

            return $this->populate($item, $entries);

        });

        return $items;

    }





    public function store($request){

        $item = new Item;
        $item->slug = $this->str->random(16);
        $item->item_id = $this->getItemIdInc();
        $item->product_code = $request->product_code;
        $item->supplier_id = $request->supplier_id;
        $item->item_category_id = $request->item_category_id;
        $item->item_type_id = $request->item_type_id;
        $item->name = $request->name;
        $item->description = $request->description;
        $item->unit_type_id = $request->unit_type_id;
        $item->beginning_balance = $this->__dataType->string_to_num($request->beginning_balance);
        $item->current_balance = $this->__dataType->string_to_num($request->beginning_balance);
        $item->unit = $request->unit;
        $item->batch_size = $request->batch_size;
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
        $item->supplier_id = $request->supplier_id;
        $item->item_category_id = $request->item_category_id;
        $item->item_type_id = $request->item_type_id;
        $item->name = $request->name;
        $item->description = $request->description;
        $item->batch_size = $request->batch_size;
        $item->min_req_qty = $this->__dataType->string_to_num($request->min_req_qty);
        $item->price = $this->__dataType->string_to_num($request->price);
        $item->updated_at = $this->carbon->now();
        $item->ip_updated = request()->ip();
        $item->user_updated = $this->auth->user()->user_id;
        $item->save();

        $item->itemRawMat()->delete();
        $item->itemPackMat()->delete();
        
        return $item;

    }





    public function updateCheckIn($amount, $item){

        $item->current_balance = $item->current_balance + $amount;
        $item->updated_at = $this->carbon->now();
        $item->ip_updated = request()->ip();
        $item->user_updated = $this->auth->user()->user_id;
        $item->save();

    }





    public function updateCheckOut($amount, $item){

        $item->current_balance = $item->current_balance - $amount;
        $item->updated_at = $this->carbon->now();
        $item->ip_updated = request()->ip();
        $item->user_updated = $this->auth->user()->user_id;
        $item->save();

    }





    public function destroy($slug){

        $item = $this->findBySlug($slug);
        $item->itemBatch()->delete();
        $item->itemRawMat()->delete();
        $item->itemPackMat()->delete();
        $item->delete();

        return $item;

    }





    public function findBySlug($slug){

        $item = $this->cache->remember('items:findBySlug:' . $slug, 240, function() use ($slug){
            return $this->item->where('slug', $slug)
                              ->with('itemCategory', 'itemBatch', 'itemLog', 'itemRawMat', 'itemPackMat')
                              ->first();
        }); 
        
        if(empty($item)){
            abort(404);
        }

        return $item;

    }





    public function findByItemId($item_id){

        $item = $this->cache->remember('items:findByItemId:' . $item_id, 240, function() use ($item_id){
            return $this->item->where('item_id', $item_id)
                              ->with('itemRawMat', 'itemPackMat')
                              ->first();
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

        return $model->select('product_code', 'item_id', 'name', 'current_balance', 'unit', 'min_req_qty', 'slug')
                     ->sortable()
                     ->orderBy('updated_at', 'desc')
                     ->paginate($entries);

    }






    public function getAll(){

        $items = $this->cache->remember('items:getAll', 240, function(){
            return $this->item->select('item_id', 'unit_type_id', 'name')
                              ->get();
        });
        
        return $items;

    }






    public function getRawMats(){

        $items = $this->cache->remember('items:getRawMats', 240, function(){
            return $this->item->select('item_id', 'unit_type_id', 'name')
                              ->where('item_category_id', 'IC10007')
                              ->get();
        });
        
        return $items;

    }






    public function getPackMats(){

        $items = $this->cache->remember('items:getPackMats', 240, function(){
            return $this->item->select('item_id', 'unit_type_id', 'name')
                              ->where('item_category_id', 'IC10004')
                              ->get();
        });
        
        return $items;

    }






    public function getByItemId($item_id){

        $items = $this->cache->remember('items:getByItemId:' . $item_id , 240, function() use ($item_id){
            return $this->item->select('unit_type_id','current_balance','unit')
                              ->where('item_id', $item_id)
                              ->orderBy('name', 'asc')
                              ->get();
        });
        
        return $items;

    }






    public function inventoryByCategory($request){

        $items = [];

        if($request->sb == 1){

            if(isset($request->ic)){
                $items = $this->item->select('item_id', 'product_code', 'name', 'unit', 'unit_type_id','current_balance', 'price', 'unit')
                                   ->where('item_category_id', $request->ic)
                                   ->orderBy('name', 'asc')
                                   ->get();
            }

        }elseif($request->sb == 2){

            if(isset($request->ic)){
                $items = $this->item->select('item_id', 'product_code', 'name', 'unit', 'unit_type_id','current_balance', 'price', 'unit')
                                   ->where('item_category_id', $request->ic)
                                   ->get();
            }

        }else{
            abort(404);
        }
        
        return $items;

    }






    public function inventoryAll($request){

        $items = [];

        if($request->sb == 1){

            $items = $this->item->select('item_id', 'product_code', 'name', 'unit', 'unit_type_id','current_balance', 'price', 'unit')
                                ->orderBy('name', 'asc')
                                ->get();
            
        }elseif($request->sb == 2){

            $items = $this->item->select('item_id', 'product_code', 'name', 'unit', 'unit_type_id','current_balance', 'price', 'unit')
                                ->get();

        }else{
            abort(404);
        }

        return $items;

    }






    public function getItemIdInc(){

        $id = 'I10001';

        $item = $this->item->select('item_id')->orderBy('item_id', 'desc')->first();

        if($item != null){

            if($item->item_id != null){
                $num = str_replace('I', '', $item->item_id) + 1;
                $id = 'I' . $num;
            }
        
        }
        
        return $id;
        
    }








}