<?php 

namespace App\Core\Subscribers;


use App\Core\BaseClasses\BaseSubscriber;



class ItemSubscriber extends BaseSubscriber{




    public function __construct(){

        parent::__construct();

    }




    public function subscribe($events){

        $events->listen('item.store', 'App\Core\Subscribers\ItemSubscriber@onStore');
        $events->listen('item.update', 'App\Core\Subscribers\ItemSubscriber@onUpdate');
        $events->listen('item.destroy', 'App\Core\Subscribers\ItemSubscriber@onDestroy');

    }




    public function onStore(){
        
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:fetch:*');

        $this->session->flash('ITEM_CREATE_SUCCESS', 'The Item has been successfully created!');

    }





    public function onUpdate($item){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:findBySlug:'. $item->slug .'');

        $this->session->flash('ITEM_UPDATE_SUCCESS', 'The Item has been successfully updated!');
        $this->session->flash('ITEM_UPDATE_SUCCESS_SLUG', $item->slug);

    }



    public function onDestroy($item){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:findBySlug:'. $item->slug .'');

        $this->session->flash('ITEM_DELETE_SUCCESS', 'The Item has been successfully deleted!');
        $this->session->flash('ITEM_DELETE_SUCCESS_SLUG', $item->slug);

    }





}