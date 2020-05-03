<?php

namespace App\Core\ViewComposers;


use View;
use App\Core\Interfaces\PurchaseOrderItemInterface;


class PurchaseOrderItemComposer{
   



	protected $po_item_repo;




	public function __construct(PurchaseOrderItemInterface $po_item_repo){

		$this->po_item_repo = $po_item_repo;

	}





    public function compose($view){

        $po_items = $this->po_item_repo->getAll();
        
    	$view->with('global_po_items_all', $po_items);

    }






}