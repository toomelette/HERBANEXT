<?php

namespace App\Core\ViewComposers;

use View;
use App\Core\Interfaces\ItemBatchInterface;


class ItemBatchComposer{
   

	protected $item_batch_repo;


	public function __construct(ItemBatchInterface $item_batch_repo){
		$this->item_batch_repo = $item_batch_repo;
	}


    public function compose($view){

        $item_batches = $this->item_batch_repo->getAll();
    	$view->with('global_item_batches_all', $item_batches);

    }



}