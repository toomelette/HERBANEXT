<?php

namespace App\Providers;
 
use Illuminate\Support\ServiceProvider;
 

class RepositoryServiceProvider extends ServiceProvider {
	


	public function register(){

		$this->app->bind('App\Core\Interfaces\UserInterface', 'App\Core\Repositories\UserRepository');

		$this->app->bind('App\Core\Interfaces\UserMenuInterface', 'App\Core\Repositories\UserMenuRepository');

		$this->app->bind('App\Core\Interfaces\UserSubmenuInterface', 'App\Core\Repositories\UserSubmenuRepository');


		$this->app->bind('App\Core\Interfaces\MenuInterface', 'App\Core\Repositories\MenuRepository');

		$this->app->bind('App\Core\Interfaces\SubmenuInterface', 'App\Core\Repositories\SubmenuRepository');

		$this->app->bind('App\Core\Interfaces\ProfileInterface', 'App\Core\Repositories\ProfileRepository');




		$this->app->bind('App\Core\Interfaces\ItemInterface', 'App\Core\Repositories\ItemRepository');

		$this->app->bind('App\Core\Interfaces\ItemCategoryInterface', 'App\Core\Repositories\ItemCategoryRepository');

		$this->app->bind('App\Core\Interfaces\ItemBatchInterface', 'App\Core\Repositories\ItemBatchRepository');

		$this->app->bind('App\Core\Interfaces\ItemLogInterface', 'App\Core\Repositories\ItemLogRepository');

		$this->app->bind('App\Core\Interfaces\PurchaseOrderInterface', 'App\Core\Repositories\PurchaseOrderRepository');

		$this->app->bind('App\Core\Interfaces\PurchaseOrderItemInterface', 'App\Core\Repositories\PurchaseOrderItemRepository');
		
		
	}



}