<?php 

namespace App\Core\Subscribers;


use App\Core\BaseClasses\BaseSubscriber;



class PurchaseOrderSubscriber extends BaseSubscriber{




    public function __construct(){

        parent::__construct();

    }




    public function subscribe($events){

        $events->listen('purchase_order.store', 'App\Core\Subscribers\PurchaseOrderSubscriber@onStore');
        $events->listen('purchase_order.update', 'App\Core\Subscribers\PurchaseOrderSubscriber@onUpdate');
        $events->listen('purchase_order.destroy', 'App\Core\Subscribers\PurchaseOrderSubscriber@onDestroy');

    }




    public function onStore(){
        
        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_orders:fetch:*');

        $this->session->flash('PURCHASE_ORDER_CREATE_SUCCESS', 'The Purchase Order has been successfully created!');

    }





    public function onUpdate($purchase_order){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_orders:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_orders:findBySlug:'. $purchase_order->slug .'');

        $this->session->flash('PURCHASE_ORDER_UPDATE_SUCCESS', 'The Purchase Order has been successfully updated!');
        $this->session->flash('PURCHASE_ORDER_UPDATE_SUCCESS_SLUG', $purchase_order->slug);

    }




    public function onDestroy($purchase_order){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_orders:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_orders:findBySlug:'. $purchase_order->slug .'');

        $this->session->flash('PURCHASE_ORDER_DELETE_SUCCESS', 'The Purchase Order has been successfully deleted!');
        $this->session->flash('PURCHASE_ORDER_DELETE_SUCCESS_SLUG', $purchase_order->slug);

    }





}