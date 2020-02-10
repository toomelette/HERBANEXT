<?php

namespace App\Core\ViewComposers;


use View;
use App\Core\Interfaces\ItemCategoryInterface;


class ItemCategoryComposer{
   



	protected $item_category_repo;




	public function __construct(ItemCategoryInterface $item_category_repo){

		$this->item_category_repo = $item_category_repo;

	}





    public function compose($view){

        $item_categories = $this->item_category_repo->getAll();
        
    	$view->with('global_item_categories_all', $item_categories);

    }






}