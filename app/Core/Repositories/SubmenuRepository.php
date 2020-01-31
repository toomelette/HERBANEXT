<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\SubmenuInterface;


use App\Models\Submenu;


class SubmenuRepository extends BaseRepository implements SubmenuInterface {
	



    protected $submenu;




	public function __construct(Submenu $submenu){

        $this->submenu = $submenu;
        parent::__construct();

    }






    public function store($data, $menu){

        $submenu = new Submenu;
        $submenu->slug = $this->str->random(16);
        $submenu->submenu_id = $this->getSubmenuIdInc();
        $submenu->menu_id = $menu->menu_id;
        $submenu->name = $data['sub_name'];
        $submenu->route = $data['sub_route'];
        $submenu->is_nav = $this->__dataType->string_to_boolean($data['sub_is_nav']);  
        $submenu->created_at = $this->carbon->now();
        $submenu->updated_at = $this->carbon->now();
        $submenu->ip_created = request()->ip();
        $submenu->ip_updated = request()->ip();
        $submenu->user_created = $this->auth->user()->user_id;
        $submenu->user_updated = $this->auth->user()->user_id;
        $submenu->save();
        
        return $submenu;

    }






    public function findBySubmenuId($submenu_id){

        $submenu = $this->cache->remember('submenus:findBySubmenuId:' . $submenu_id, 240, function() use ($submenu_id){
            return $this->submenu->where('submenu_id', $submenu_id)->first();
        });
        
        if(empty($submenu)){
            abort(404);
        }
        
        return $submenu;

    }






    public function getSubmenuIdInc(){

        $id = 'SM100001';

        $submenu = $this->submenu->select('submenu_id')->orderBy('submenu_id', 'desc')->first();

        if($submenu != null){
            $num = str_replace('SM', '', $submenu->submenu_id) + 1;
            $id = 'SM' . $num;
        }
        
        return $id;
        
    }






    public function getAll(){

        $submenus = $this->cache->remember('submenus:getAll', 240, function(){
            return $this->submenu->select('menu_id','submenu_id', 'name', 'is_nav')
                                 ->orderBy('submenu_id', 'asc')->get();
        });
        
        return $submenus;

    }






    public function getByMenuId($menu_id){

        $submenu = $this->cache->remember('submenus:getByMenuId:'. $menu_id .'', 240, function() use ($menu_id){

            return $this->submenu->select('submenu_id', 'name')
                                 ->where('menu_id', $menu_id)
                                 ->orderBy('submenu_id', 'asc')
                                 ->get();

        });

        return $submenu;

    }







}