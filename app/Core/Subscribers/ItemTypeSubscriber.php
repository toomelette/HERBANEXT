<?php 

namespace App\Core\Subscribers;


use App\Core\BaseClasses\BaseSubscriber;



class ItemTypeSubscriber extends BaseSubscriber{




    public function __construct(){

        parent::__construct();

    }




    public function subscribe($events){

        $events->listen('item_type.store', 'App\Core\Subscribers\ItemTypeSubscriber@onStore');
        $events->listen('item_type.update', 'App\Core\Subscribers\ItemTypeSubscriber@onUpdate');
        $events->listen('item_type.destroy', 'App\Core\Subscribers\ItemTypeSubscriber@onDestroy');

    }




    public function onStore(){
        
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_types:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_types:getAll');

        $this->session->flash('ITEM_TYPE_CREATE_SUCCESS', 'The Item has been successfully created!');

    }





    public function onUpdate($item_type){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_types:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_types:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_types:findBySlug:'. $item_type->slug .'');

        $this->session->flash('ITEM_TYPE_UPDATE_SUCCESS', 'The Item has been successfully updated!');
        $this->session->flash('ITEM_TYPE_UPDATE_SUCCESS_SLUG', $item_type->slug);

    }



    public function onDestroy($item_type){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_types:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_types:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_types:findBySlug:'. $item_type->slug .'');

        $this->session->flash('ITEM_TYPE_DELETE_SUCCESS', 'The Item has been successfully deleted!');
        $this->session->flash('ITEM_TYPE_DELETE_SUCCESS_SLUG', $item_type->slug);

    }





}