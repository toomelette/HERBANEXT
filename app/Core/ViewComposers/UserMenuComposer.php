<?php

namespace App\Core\ViewComposers;


use View;
use Auth;
use App\Core\Interfaces\UserMenuInterface;


class UserMenuComposer{
   


    protected $user_menu_repo;
	protected $auth;




	public function __construct(UserMenuInterface $user_menu_repo){

        $this->user_menu_repo = $user_menu_repo;
		$this->auth = auth();
    
	}





    public function compose($view){

        $user_menus = [];


        if($this->auth->check()){

            $user_menus = $this->user_menu_repo->getAll();

        }  


    	$view->with('global_user_menus', $user_menus);


    }






}