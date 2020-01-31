<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\UserSubmenuInterface;

use Route;
use App\Models\UserSubmenu;


class UserSubmenuRepository extends BaseRepository implements UserSubmenuInterface {
	



    protected $user_submenu;




	public function __construct(UserSubmenu $user_submenu){

        $this->user_submenu = $user_submenu;
        parent::__construct();

    }






    public function store($submenu, $user_menu){

        $user_submenu = new UserSubMenu;
        $user_submenu->submenu_id = $submenu->submenu_id;
        $user_submenu->user_menu_id = $user_menu->user_menu_id;
        $user_submenu->user_id = $user_menu->user_id;
        $user_submenu->is_nav = $submenu->is_nav;
        $user_submenu->name = $submenu->name;
        $user_submenu->route = $submenu->route;
        $user_submenu->save();

        return $user_submenu;

    }






    public function isExist() {

        $user_id = $this->auth->user()->user_id;
        $route_name = Route::currentRouteName();

        $user_submenu = $this->cache->remember('nav:user_submenus:byUserId:' . $user_id .':byRoute:'. $route_name, 240, function() use($user_id, $route_name){
            $usm = $this->user_submenu->where('route', $route_name)
                                      ->where('user_id', $user_id)
                                      ->exists();
            return $usm;
        });

        return $user_submenu;

    }







}