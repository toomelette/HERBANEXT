<?php

namespace App\Core\ViewComposers;


use View;
use Auth;
use App\Core\Interfaces\UserSubmenuInterface;


class UserSubmenuComposer{
   


    protected $user_submenu_repo;
	protected $auth;




	public function __construct(UserSubmenuInterface $user_submenu_repo){

        $this->user_submenu_repo = $user_submenu_repo;
		$this->auth = auth();
    
	}





    public function compose($view){

        $user_submenus = [];

        if($this->auth->check()){
            $user_submenus = $this->user_submenu_repo->getAll();
            $user_submenus = $user_submenus->pluck('route')->toArray();
        }  

    	$view->with('global_user_submenus', $user_submenus);

    }






}