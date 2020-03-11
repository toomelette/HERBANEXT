<?php 

namespace App\Core\Subscribers;


use App\Core\BaseClasses\BaseSubscriber;



class JobOrderSubscriber extends BaseSubscriber{




    public function __construct(){

        parent::__construct();

    }




    public function subscribe($events){

        $events->listen('job_order.generate', 'App\Core\Subscribers\JobOrderSubscriber@onGenerate');

    }




    public function onGenerate($slug){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_order_items:findBySlug:'. $slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_order_items:fetch:*');

        $this->session->flash('JOB_ORDER_GENERATE_SUCCESS', 'The Job Order has been successfully created!');
        $this->session->flash('JOB_ORDER_GENERATE_SUCCESS_SLUG', $slug);

    }





}