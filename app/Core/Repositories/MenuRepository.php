<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\MenuInterface;

use App\Models\Menu;


class MenuRepository extends BaseRepository implements MenuInterface {
	


    protected $menu;



	public function __construct(Menu $menu){

        $this->menu = $menu;
        parent::__construct();

    }





    public function fetch($request){

        $key = str_slug($request->fullUrl(), '_');

        $menus = $this->cache->remember('menus:fetch:' . $key, 240, function() use ($request){

            $menu = $this->menu->newQuery();
            
            if(isset($request->q)){
                $this->search($menu, $request->q);
            }

            return $this->populate($menu);

        });

        return $menus;

    }





    public function store($request){

        $menu = new Menu;
        $menu->menu_id = $this->getMenuIdInc();
        $menu->slug = $this->str->random(16);
        $menu->name = $request->name;
        $menu->route = $request->route;
        $menu->icon = $request->icon;
        $menu->is_menu = $this->__dataType->string_to_boolean($request->is_menu);
        $menu->is_dropdown = $this->__dataType->string_to_boolean($request->is_dropdown);
        $menu->created_at = $this->carbon->now();
        $menu->updated_at = $this->carbon->now();
        $menu->ip_created = request()->ip();
        $menu->ip_updated = request()->ip();
        $menu->user_created = $this->auth->user()->user_id;
        $menu->user_updated = $this->auth->user()->user_id;
        $menu->save();
        
        return $menu;

    }





    public function update($request, $slug){

        $menu = $this->findBySlug($slug);
        $menu->name = $request->name;
        $menu->route = $request->route;
        $menu->icon = $request->icon;
        $menu->is_menu = $this->__dataType->string_to_boolean($request->is_menu);
        $menu->is_dropdown = $this->__dataType->string_to_boolean($request->is_dropdown);
        $menu->updated_at = $this->carbon->now();
        $menu->ip_updated = request()->ip();
        $menu->user_updated = $this->auth->user()->user_id;
        $menu->save();

        return $menu;

    }





    public function destroy($slug){

        $menu = $this->findBySlug($slug);
        $menu->delete();
        $menu->submenu()->delete();

        return $menu;

    }





    public function findBySlug($slug){

        $menu = $this->cache->remember('menus:findBySlug:' . $slug, 240, function() use ($slug){
            return $this->menu->where('slug', $slug)->first();
        }); 
        
        if(empty($menu)){
            abort(404);
        }

        return $menu;

    }






    public function findByMenuId($menu_id){

        $menu = $this->cache->remember('menus:findByMenuId:' . $menu_id, 240, function() use ($menu_id){
            return $this->menu->where('menu_id', $menu_id)->first();
        });
        
        if(empty($menu)){
            abort(404);
        }
        
        return $menu;

    }






    public function search($model, $key){

        return $model->where(function ($model) use ($key) {
                $model->where('name', 'LIKE', '%'. $key .'%');
        });

    }





    public function populate($model){

        return $model->select('name', 'route', 'icon', 'slug')
                     ->sortable()
                     ->orderBy('updated_at', 'desc')
                     ->paginate(10);

    }






    public function getMenuIdInc(){

        $id = 'M10001';

        $menu = $this->menu->select('menu_id')->orderBy('menu_id', 'desc')->first();

        if($menu != null){

            if($menu->menu_id != null){
                $num = str_replace('M', '', $menu->menu_id) + 1;
                $id = 'M' . $num;
            }
        
        }
        
        return $id;
        
    }






    public function getAll(){

        $menus = $this->cache->remember('menus:getAll', 240, function(){
            return $this->menu->select('menu_id', 'name')->get();
        });
        
        return $menus;

    }






}