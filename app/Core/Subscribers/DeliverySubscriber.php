<?php 

namespace App\Core\Subscribers;


use App\Core\BaseClasses\BaseSubscriber;



class DeliverySubscriber extends BaseSubscriber{




    public function __construct(){

        parent::__construct();

    }




    public function subscribe($events){

        $events->listen('delivery.store', 'App\Core\Subscribers\DeliverySubscriber@onStore');
        $events->listen('delivery.update', 'App\Core\Subscribers\DeliverySubscriber@onUpdate');
        $events->listen('delivery.destroy', 'App\Core\Subscribers\DeliverySubscriber@onDestroy');
        $events->listen('delivery.flush_po_item', 'App\Core\Subscribers\DeliverySubscriber@onFlushPOItem');

    }




    public function onStore(){
        
        $this->__cache->deletePattern(''. config('app.name') .'_cache:deliveries:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_order_items:getAll');

        $this->session->flash('DELIVERY_CREATE_SUCCESS', 'The Delivery has been successfully created!');

    }





    public function onUpdate($delivery){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:deliveries:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_order_items:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:deliveries:findBySlug:'. $delivery->slug .'');

        $this->session->flash('DELIVERY_UPDATE_SUCCESS', 'The Delivery has been successfully updated!');
        $this->session->flash('DELIVERY_UPDATE_SUCCESS_SLUG', $delivery->slug);

    }



    public function onDestroy($delivery){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:deliveries:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_order_items:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:deliveries:findBySlug:'. $delivery->slug .'');

        $this->session->flash('DELIVERY_DELETE_SUCCESS', 'The Delivery has been successfully deleted!');
        $this->session->flash('DELIVERY_DELETE_SUCCESS_SLUG', $delivery->slug);

    }



    public function onFlushPOItem($po_item_id){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_order_items:findByPOItemId:'. $po_item_id .'');

    }





}