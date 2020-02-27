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
        $raw_mat_items = $this->item_repo->getRawMats();
        $pack_mat_items = $this->item_repo->getPackMats();
        
    	$view->with([
    		'global_items_all' => $items,
    		'global_raw_mat_items_all' => $raw_mat_items,
    		'global_pack_mat_items_all' => $pack_mat_items,
    	]);

    }






}