<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\ItemCategoryInterface;

use App\Models\ItemCategory;


class ItemCategoryRepository extends BaseRepository implements ItemCategoryInterface {
	


    protected $item_category;



	public function __construct(ItemCategory $item_category){

        $this->item_category = $item_category;
        parent::__construct();

    }





    public function fetch($request){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $item_categories = $this->cache->remember('item_categories:fetch:' . $key, 240, function() use ($request, $entries){

            $item_category = $this->item_category->newQuery();
            
            if(isset($request->q)){
                $this->search($item_category, $request->q);
            }

            return $this->populate($item_category, $entries);

        });

        return $item_categories;

    }





    public function store($request){

        $item_category = new ItemCategory;
        $item_category->slug = $this->str->random(16);
        $item_category->item_category_id = $this->getItemCategoryIdInc();
        $item_category->name = $request->name;
        $item_category->description = $request->description;
        $item_category->created_at = $this->carbon->now();
        $item_category->updated_at = $this->carbon->now();
        $item_category->ip_created = request()->ip();
        $item_category->ip_updated = request()->ip();
        $item_category->user_created = $this->auth->user()->user_id;
        $item_category->user_updated = $this->auth->user()->user_id;
        $item_category->save();
        
        return $item_category;

    }





    public function update($request, $slug){

        $item_category = $this->findBySlug($slug);
        $item_category->name = $request->name;
        $item_category->description = $request->description;
        $item_category->updated_at = $this->carbon->now();
        $item_category->ip_updated = request()->ip();
        $item_category->user_updated = $this->auth->user()->user_id;
        $item_category->save();
        
        return $item_category;

    }





    public function destroy($slug){

        $item_category = $this->findBySlug($slug);
        $item_category->delete();

        return $item_category;

    }





    public function findBySlug($slug){

        $item_category = $this->cache->remember('item_categories:findBySlug:' . $slug, 240, function() use ($slug){
            return $this->item_category->where('slug', $slug)->first();
        }); 
        
        if(empty($item_category)){
            abort(404);
        }

        return $item_category;

    }





    public function findByItemCatId($item_cat_id){

        $item_category = $this->cache->remember('item_categories:findByItemCatId:' . $item_cat_id, 240, function() use ($item_cat_id){
            return $this->item_category->where('item_category_id', $item_cat_id)->first();
        }); 
        
        if(empty($item_category)){
            abort(404);
        }

        return $item_category;

    }






    public function search($model, $key){

        return $model->where(function ($model) use ($key) {
                $model->where('name', 'LIKE', '%'. $key .'%')
                      ->orWhere('description', 'LIKE', '%'. $key .'%');
        });

    }





    public function populate($model, $entries){

        return $model->select('name', 'description', 'slug')
                     ->sortable()
                     ->orderBy('updated_at', 'desc')
                     ->paginate($entries);

    }






    public function getItemCategoryIdInc(){

        $id = 'IC10001';

        $item_category = $this->item_category->select('item_category_id')->orderBy('item_category_id', 'desc')->first();

        if($item_category != null){

            if($item_category->item_category_id != null){
                $num = str_replace('IC', '', $item_category->item_category_id) + 1;
                $id = 'IC' . $num;
            }
        
        }
        
        return $id;
        
    }






    public function getAll(){

        $item_categories = $this->cache->remember('item_categories:getAll', 240, function(){
            return $this->item_category->select('item_category_id', 'name')->get();
        });
        
        return $item_categories;

    }








}