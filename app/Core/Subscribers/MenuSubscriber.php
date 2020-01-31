<?php 

namespace App\Core\Subscribers;


use App\Core\BaseClasses\BaseSubscriber;



class MenuSubscriber extends BaseSubscriber{




    public function __construct(){

        parent::__construct();

    }




    public function subscribe($events){

        $events->listen('menu.store', 'App\Core\Subscribers\MenuSubscriber@onStore');
        $events->listen('menu.update', 'App\Core\Subscribers\MenuSubscriber@onUpdate');
        $events->listen('menu.destroy', 'App\Core\Subscribers\MenuSubscriber@onDestroy');

    }




    public function onStore(){
        
        $this->__cache->deletePattern(''. config('app.name') .'_cache:menus:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:menus:getAll');
        
        $this->__cache->deletePattern(''. config('app.name') .'_cache:submenus:getAll');

        $this->session->flash('MENU_CREATE_SUCCESS', 'The Menu has been successfully created!');

    }





    public function onUpdate($menu){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:menus:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:menus:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:menus:findBySlug:'. $menu->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:menus:findByMenuId:'. $menu->menu_id .'');
        
        $this->__cache->deletePattern(''. config('app.name') .'_cache:submenus:getAll');

        $this->session->flash('MENU_UPDATE_SUCCESS', 'The Menu has been successfully updated!');
        $this->session->flash('MENU_UPDATE_SUCCESS_SLUG', $menu->slug);

    }



    public function onDestroy($menu){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:menus:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:menus:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:menus:findBySlug:'. $menu->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:menus:findByMenuId:'. $menu->menu_id .'');

        $this->__cache->deletePattern(''. config('app.name') .'_cache:submenus:getAll');

        $this->session->flash('MENU_DELETE_SUCCESS', 'The Menu has been successfully deleted!');
        $this->session->flash('MENU_DELETE_SUCCESS_SLUG', $menu->slug);

    }





}