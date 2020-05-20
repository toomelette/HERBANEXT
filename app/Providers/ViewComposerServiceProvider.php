<?php

namespace App\Providers;


use View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider{

    
    public function boot(){

        /** VIEW COMPOSERS  **/


        // USERMENU
        View::composer('layouts.admin-sidenav', 'App\Core\ViewComposers\UserMenuComposer');


        // MENU
        View::composer(['dashboard.user.create', 
                        'dashboard.user.edit'], 'App\Core\ViewComposers\MenuComposer');
        

        // SUBMENU
        View::composer(['dashboard.user.create', 
                        'dashboard.user.edit'], 'App\Core\ViewComposers\SubmenuComposer');


        // ITEMS
        View::composer(['dashboard.purchase_order.create', 
                        'dashboard.purchase_order.edit',
                        'dashboard.item.create',
                        'dashboard.item.edit',
                        'dashboard.task.create',
                        'dashboard.task.edit'], 'App\Core\ViewComposers\ItemComposer');
        

        // ITEM CATEGORY
        View::composer(['dashboard.item.create', 
                        'dashboard.item.edit',
                        'dashboard.item.index'], 'App\Core\ViewComposers\ItemCategoryComposer');


        // ITEM TYPES
        View::composer(['dashboard.item.create',
                        'dashboard.item.edit'], 'App\Core\ViewComposers\ItemTypeComposer');


        // USER ROUTES
        View::composer(['*'], 'App\Core\ViewComposers\UserSubmenuComposer');

        

        // PERSONNELS
        View::composer(['dashboard.task.create',
                        'dashboard.task.edit'], 'App\Core\ViewComposers\PersonnelComposer');


        // MACHINES
        View::composer(['dashboard.task.create',
                        'dashboard.task.edit'], 'App\Core\ViewComposers\MachineComposer');


        // PO Items
        View::composer(['dashboard.delivery.create',
                        'dashboard.delivery.edit'], 'App\Core\ViewComposers\PurchaseOrderItemComposer');
        

        // ITEM BATCHES
        View::composer(['dashboard.item.index'], 'App\Core\ViewComposers\ItemBatchComposer');
        

        // SUPPLIERS
        View::composer(['dashboard.item.create', 
                        'dashboard.item.edit',
                        'dashboard.item.index'], 'App\Core\ViewComposers\SupplierComposer');
        
    }

    




    
    public function register(){

      


    
    }




}
