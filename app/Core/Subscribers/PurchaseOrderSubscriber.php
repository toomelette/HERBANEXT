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
        $events->listen('purchase_order.toProcess', 'App\Core\Subscribers\PurchaseOrderSubscriber@onToProcess');
        $events->listen('purchase_order.toBuffer', 'App\Core\Subscribers\PurchaseOrderSubscriber@onToBuffer');

    }




    public function onStore($purchase_order){
        
        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_orders:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_orders:fetchBuffer:*');

        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_order_items:fetch:*');

        $this->session->flash('PURCHASE_ORDER_CREATE_SUCCESS', 'The Purchase Order has been successfully created!');
        $this->session->flash('PURCHASE_ORDER_CREATE_SUCCESS_SLUG', $purchase_order->slug);

    }





    public function onUpdate($purchase_order){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_orders:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_orders:fetchBuffer:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_orders:findBySlug:'. $purchase_order->slug .'');

        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_order_items:fetch:*');

        $this->session->flash('PURCHASE_ORDER_UPDATE_SUCCESS', 'The Purchase Order has been successfully updated!');
        $this->session->flash('PURCHASE_ORDER_UPDATE_SUCCESS_SLUG', $purchase_order->slug);

    }




    public function onDestroy($purchase_order){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_orders:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_orders:fetchBuffer:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_orders:findBySlug:'. $purchase_order->slug .'');

        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_order_items:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:manufacturing_order_items:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:finishing_order_items:fetch:*');

        $this->session->flash('PURCHASE_ORDER_DELETE_SUCCESS', 'The Purchase Order has been successfully deleted!');
        $this->session->flash('PURCHASE_ORDER_DELETE_SUCCESS_SLUG', $purchase_order->slug);

    }




    public function onToProcess($purchase_order){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_orders:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_orders:fetchBuffer:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_orders:findBySlug:'. $purchase_order->slug .'');

        $this->session->flash('PURCHASE_ORDER_TO_PROCESS_SUCCESS', 'The Purchase Order has been successfully transfered to process list!');

    }




    public function onToBuffer($purchase_order){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_orders:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_orders:fetchBuffer:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_orders:findBySlug:'. $purchase_order->slug .'');

        $this->session->flash('PURCHASE_ORDER_TO_BUFFER_SUCCESS', 'The Purchase Order has been successfully transfered to buffer list!');

    }





}