<?php

namespace App\Core\ViewComposers;


use View;
use App\Core\Interfaces\MenuInterface;


class MenuComposer{
   



	protected $menu_repo;




	public function __construct(MenuInterface $menu_repo){

		$this->menu_repo = $menu_repo;

	}





    public function compose($view){

        $menus = $this->menu_repo->getAll();
        
    	$view->with('global_menus_all', $menus);

    }






}