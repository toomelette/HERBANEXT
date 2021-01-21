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
                        'dashboard.task.edit',
                        'dashboard.task.index',
                        'dashboard.task.scheduling'], 'App\Core\ViewComposers\ItemComposer');
        

        // ITEM CATEGORY
        View::composer(['dashboard.item.create', 
                        'dashboard.item.edit',
                        'dashboard.item.index',
                        'dashboard.item.reports'], 'App\Core\ViewComposers\ItemCategoryComposer');


        // ITEM TYPES
        View::composer(['dashboard.item.create',
                        'dashboard.item.edit'], 'App\Core\ViewComposers\ItemTypeComposer');


        // USER ROUTES
        View::composer(['*'], 'App\Core\ViewComposers\UserSubmenuComposer');

        

        // PERSONNELS
        View::composer(['dashboard.task.create',
                        'dashboard.task.edit',
                        'dashboard.engr_task.create_jo',
                        'dashboard.engr_task.create_da',
                        'dashboard.engr_task.edit_jo',
                        'dashboard.engr_task.edit_da'], 'App\Core\ViewComposers\PersonnelComposer');


        // MACHINES
        View::composer(['dashboard.task.create',
                        'dashboard.task.edit',
                        'dashboard.machine.maintenance',
                        'dashboard.task.index',
                        'dashboard.task.scheduling'], 'App\Core\ViewComposers\MachineComposer');


        // PO Items
        View::composer(['dashboard.delivery.create',
                        'dashboard.delivery.edit'], 'App\Core\ViewComposers\PurchaseOrderItemComposer');
        

        // ITEM BATCHES
        View::composer(['dashboard.item.index'], 'App\Core\ViewComposers\ItemBatchComposer');
        

        // SUPPLIERS
        View::composer(['dashboard.item.create', 
                        'dashboard.item.edit',
                        'dashboard.item.index'], 'App\Core\ViewComposers\SupplierComposer');
        

        // JOB ORDER
        View::composer(['dashboard.delivery.create',
                        'dashboard.delivery.edit'], 'App\Core\ViewComposers\JobOrderComposer');
        
        
    }

    




    
    public function register(){

      


    
    }




}
