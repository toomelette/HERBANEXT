<?php 

namespace App\Core\Subscribers;


use App\Core\BaseClasses\BaseSubscriber;



class JobOrderSubscriber extends BaseSubscriber{




    public function __construct(){

        parent::__construct();

    }




    public function subscribe($events){

        $events->listen('job_order.generate', 'App\Core\Subscribers\JobOrderSubscriber@onGenerate');
        $events->listen('job_order.generate_fill_post', 'App\Core\Subscribers\JobOrderSubscriber@onGenerateFillPost');
        $events->listen('job_order.confirm_rfd', 'App\Core\Subscribers\JobOrderSubscriber@onConfirmRFD');

    }




    public function onGenerate($slug){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_order_items:findBySlug:'. $slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_order_items:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_orders:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:job_orders:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:job_orders:getAll');

        $this->session->flash('JOB_ORDER_GENERATE_SUCCESS', 'The Job Order has been successfully generated!');
        $this->session->flash('JOB_ORDER_GENERATE_SUCCESS_SLUG', $slug);

    }




    public function onGenerateFillPost($slug, $jo_id){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_orders:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_order_items:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_order_items:findBySlug:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:job_orders:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:job_orders:findByJoId:'. $jo_id .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:job_orders:findBySlug:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:job_orders:getAll');

        $this->session->flash('JOB_ORDER_GENERATE_FILL_POST_SUCCESS', 'The Job Order has been successfully posted!');
        $this->session->flash('JOB_ORDER_GENERATE_FILL_POST_SUCCESS_SLUG', $slug);

    }




    public function onConfirmRFD($jo){
        
        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_order_items:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:job_orders:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:job_orders:findByJoId:'. $jo->jo_id .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:job_orders:findBySlug:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:job_orders:getAll');

        $this->session->flash('JOB_ORDER_CONFIRM_RFD_SUCCESS', 'The Job Order has been successfully updated delivery status!');
        $this->session->flash('JOB_ORDER_CONFIRM_RFD_SUCCESS_SLUG', $jo->slug);

    }





}