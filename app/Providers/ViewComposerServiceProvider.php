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
        

        // ITEM CATEGORY
        View::composer(['dashboard.item.create', 
                        'dashboard.item.edit'], 'App\Core\ViewComposers\ItemCategoryComposer');

        

        // ITEMS
        View::composer(['dashboard.purchase_order.create', 
                        'dashboard.purchase_order.edit'], 'App\Core\ViewComposers\ItemComposer');
        
    }

    




    
    public function register(){

      


    
    }




}
