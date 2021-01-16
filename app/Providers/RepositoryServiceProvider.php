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

		$this->app->bind('App\Core\Interfaces\ItemRawMatInterface', 'App\Core\Repositories\ItemRawMatRepository');

		$this->app->bind('App\Core\Interfaces\ItemPackMatInterface', 'App\Core\Repositories\ItemPackMatRepository');

		$this->app->bind('App\Core\Interfaces\ItemTypeInterface', 'App\Core\Repositories\ItemTypeRepository');

		$this->app->bind('App\Core\Interfaces\PurchaseOrderInterface', 'App\Core\Repositories\PurchaseOrderRepository');

		$this->app->bind('App\Core\Interfaces\PurchaseOrderItemInterface', 'App\Core\Repositories\PurchaseOrderItemRepository');

		$this->app->bind('App\Core\Interfaces\PurchaseOrderItemRawMatInterface', 'App\Core\Repositories\PurchaseOrderItemRawMatRepository');

		$this->app->bind('App\Core\Interfaces\PurchaseOrderItemPackMatInterface', 'App\Core\Repositories\PurchaseOrderItemPackMatRepository');

		$this->app->bind('App\Core\Interfaces\JobOrderInterface', 'App\Core\Repositories\JobOrderRepository');

		$this->app->bind('App\Core\Interfaces\ManufacturingOrderInterface', 'App\Core\Repositories\ManufacturingOrderRepository');

		$this->app->bind('App\Core\Interfaces\ManufacturingOrderRawMatInterface', 'App\Core\Repositories\ManufacturingOrderRawMatRepository');

		$this->app->bind('App\Core\Interfaces\FinishingOrderInterface', 'App\Core\Repositories\FinishingOrderRepository');

		$this->app->bind('App\Core\Interfaces\FinishingOrderPackMatInterface', 'App\Core\Repositories\FinishingOrderPackMatRepository');

		$this->app->bind('App\Core\Interfaces\PersonnelInterface', 'App\Core\Repositories\PersonnelRepository');

		$this->app->bind('App\Core\Interfaces\MachineInterface', 'App\Core\Repositories\MachineRepository');

		$this->app->bind('App\Core\Interfaces\MachineMaintenanceInterface', 'App\Core\Repositories\MachineMaintenanceRepository');

		$this->app->bind('App\Core\Interfaces\TaskInterface', 'App\Core\Repositories\TaskRepository');

		$this->app->bind('App\Core\Interfaces\TaskPersonnelInterface', 'App\Core\Repositories\TaskPersonnelRepository');

		$this->app->bind('App\Core\Interfaces\DeliveryInterface', 'App\Core\Repositories\DeliveryRepository');

		$this->app->bind('App\Core\Interfaces\DeliveryItemInterface', 'App\Core\Repositories\DeliveryItemRepository');

		$this->app->bind('App\Core\Interfaces\DeliveryJOInterface', 'App\Core\Repositories\DeliveryJORepository');

		$this->app->bind('App\Core\Interfaces\SupplierInterface', 'App\Core\Repositories\SupplierRepository');

		$this->app->bind('App\Core\Interfaces\EngrTaskInterface', 'App\Core\Repositories\EngrTaskRepository');

		$this->app->bind('App\Core\Interfaces\EngrTaskPersonnelInterface', 'App\Core\Repositories\EngrTaskPersonnelRepository');
		
		
		
	}



}