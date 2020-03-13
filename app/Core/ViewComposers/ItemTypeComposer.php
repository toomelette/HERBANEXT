<?php

namespace App\Core\ViewComposers;


use View;
use App\Core\Interfaces\ItemTypeInterface;


class ItemTypeComposer{
   



	protected $item_type_repo;




	public function __construct(ItemTypeInterface $item_type_repo){

		$this->item_type_repo = $item_type_repo;

	}





    public function compose($view){

        $item_types = $this->item_type_repo->getAll();
        
    	$view->with('global_item_types_all', $item_types);

    }






}