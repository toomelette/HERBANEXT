<?php

namespace App\Core\ViewComposers;


use View;
use App\Core\Interfaces\PersonnelInterface;


class PersonnelComposer{
   

	protected $personnel_repo;


	public function __construct(PersonnelInterface $personnel_repo){
		$this->personnel_repo = $personnel_repo;
	}


    public function compose($view){
        $personnels = $this->personnel_repo->getAll();
    	$view->with('global_personnels_all', $personnels);
    }


}