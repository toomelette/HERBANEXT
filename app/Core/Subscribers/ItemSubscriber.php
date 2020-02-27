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
        $events->listen('item.check_in', 'App\Core\Subscribers\ItemSubscriber@onCheckIn');
        $events->listen('item.check_out', 'App\Core\Subscribers\ItemSubscriber@onCheckOut');


    }




    public function onStore(){
        
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:getRawMats');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:getPackMats');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:getByProductCode:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_batches:fetchByItem:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_logs:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_logs:fetchByItem:*');

        $this->session->flash('ITEM_CREATE_SUCCESS', 'The Item has been successfully created!');

    }





    public function onUpdate($item){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:getRawMats');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:getPackMats');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:getByProductCode:'. $item->product_code .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:findBySlug:'. $item->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:findByProductCode:'. $item->product_code .'');

        $this->session->flash('ITEM_UPDATE_SUCCESS', 'The Item has been successfully updated!');
        $this->session->flash('ITEM_UPDATE_SUCCESS_SLUG', $item->slug);

    }



    public function onDestroy($item){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:getRawMats');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:getPackMats');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:getByProductCode:'. $item->product_code .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_batches:fetchByItem:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_logs:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_logs:fetchByItem:*');

        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:findBySlug:'. $item->slug .'');

        $this->session->flash('ITEM_DELETE_SUCCESS', 'The Item has been successfully deleted!');
        $this->session->flash('ITEM_DELETE_SUCCESS_SLUG', $item->slug);

    }





    public function onCheckIn($item){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_batches:fetchByItem:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_logs:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_logs:fetchByItem:*');

        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:findBySlug:'. $item->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:findByProductCode:'. $item->product_code .'');

        $this->session->flash('ITEM_CHECK_IN_SUCCESS', 'The Item batch has been successfully check in!');
        $this->session->flash('ITEM_CHECK_IN_SUCCESS_SLUG', $item->slug);

    }





    public function onCheckOut($item){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_batches:fetchByItem:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_logs:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_logs:fetchByItem:*');
        
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:findBySlug:'. $item->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:findByProductCode:'. $item->product_code .'');

        $this->session->flash('ITEM_CHECK_OUT_SUCCESS', 'The Amount has been successfully check out!');
        $this->session->flash('ITEM_CHECK_OUT_SUCCESS_SLUG', $item->slug);

    }





}