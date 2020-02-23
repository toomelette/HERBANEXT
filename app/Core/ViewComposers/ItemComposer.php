<?php

namespace App\Core\ViewComposers;


use View;
use App\Core\Interfaces\ItemInterface;


class ItemComposer{
   



	protected $item_repo;




	public function __construct(ItemInterface $item_repo){

		$this->item_repo = $item_repo;

	}





    public function compose($view){

        $items = $this->item_repo->getAll();
        
    	$view->with('global_items_all', $items);

    }






}