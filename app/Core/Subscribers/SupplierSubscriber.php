<?php 

namespace App\Core\Subscribers;


use App\Core\BaseClasses\BaseSubscriber;



class SupplierSubscriber extends BaseSubscriber{




    public function __construct(){

        parent::__construct();

    }




    public function subscribe($events){

        $events->listen('supplier.store', 'App\Core\Subscribers\SupplierSubscriber@onStore');
        $events->listen('supplier.update', 'App\Core\Subscribers\SupplierSubscriber@onUpdate');
        $events->listen('supplier.destroy', 'App\Core\Subscribers\SupplierSubscriber@onDestroy');

    }




    public function onStore(){
        
        $this->__cache->deletePattern(''. config('app.name') .'_cache:suppliers:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:suppliers:getAll');

        $this->session->flash('SUPPLIER_CREATE_SUCCESS', 'The Supplier has been successfully created!');

    }





    public function onUpdate($supplier){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:suppliers:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:suppliers:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:suppliers:findBySlug:'. $supplier->slug .'');

        $this->session->flash('SUPPLIER_UPDATE_SUCCESS', 'The Supplier has been successfully updated!');
        $this->session->flash('SUPPLIER_UPDATE_SUCCESS_SLUG', $supplier->slug);

    }



    public function onDestroy($supplier){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:suppliers:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:suppliers:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:suppliers:findBySlug:'. $supplier->slug .'');

        $this->session->flash('SUPPLIER_DELETE_SUCCESS', 'The Supplier has been successfully deleted!');
        $this->session->flash('SUPPLIER_DELETE_SUCCESS_SLUG', $supplier->slug);

    }





}