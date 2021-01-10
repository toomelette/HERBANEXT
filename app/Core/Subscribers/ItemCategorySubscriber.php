<?php 

namespace App\Core\Subscribers;


use App\Core\BaseClasses\BaseSubscriber;



class ItemCategorySubscriber extends BaseSubscriber{




    public function __construct(){

        parent::__construct();

    }




    public function subscribe($events){

        $events->listen('item_category.store', 'App\Core\Subscribers\ItemCategorySubscriber@onStore');
        $events->listen('item_category.update', 'App\Core\Subscribers\ItemCategorySubscriber@onUpdate');
        $events->listen('item_category.destroy', 'App\Core\Subscribers\ItemCategorySubscriber@onDestroy');

    }




    public function onStore(){
        
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_categories:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_categories:getAll');

        $this->session->flash('ITEM_CATEGORY_CREATE_SUCCESS', 'The Item has been successfully created!');

    }





    public function onUpdate($item_category){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_categories:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_categories:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_categories:findBySlug:'. $item_category->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_categories:findByItemCatId:'. $item_category->item_category_id .'');

        $this->session->flash('ITEM_CATEGORY_UPDATE_SUCCESS', 'The Item has been successfully updated!');
        $this->session->flash('ITEM_CATEGORY_UPDATE_SUCCESS_SLUG', $item_category->slug);

    }



    public function onDestroy($item_category){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_categories:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_categories:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_categories:findBySlug:'. $item_category->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_categories:findByItemCatId:'. $item_category->item_category_id .'');

        $this->session->flash('ITEM_CATEGORY_DELETE_SUCCESS', 'The Item has been successfully deleted!');
        $this->session->flash('ITEM_CATEGORY_DELETE_SUCCESS_SLUG', $item_category->slug);

    }





}