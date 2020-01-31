<?php

namespace App\Core\ViewComposers;


use View;
use App\Core\Interfaces\SubmenuInterface;



class SubmenuComposer{
   


	protected $submenu_repo;




	public function __construct(SubmenuInterface $submenu_repo){

		$this->submenu_repo = $submenu_repo;

	}





    public function compose($view){

        $submenus = $this->submenu_repo->getAll();
        
    	$view->with('global_submenus_all', $submenus);

    }






}