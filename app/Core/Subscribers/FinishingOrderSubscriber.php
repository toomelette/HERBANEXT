<?php 

namespace App\Core\Subscribers;


use App\Core\BaseClasses\BaseSubscriber;



class FinishingOrderSubscriber extends BaseSubscriber{


    public function __construct(){
        parent::__construct();
    }


    public function subscribe($events){
        $events->listen('finishing_order.fill_up_post', 'App\Core\Subscribers\FinishingOrderSubscriber@onFillUpPost');
    }


    public function onFillUpPost($fo){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:finishing_orders:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:finishing_orders:findBySlug:'. $fo->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_order_items:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:job_orders:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:purchase_orders:fetch:*');

        $this->session->flash('FO_FILL_UP_POST_SUCCESS', 'The FO has been successfully posted!');
        $this->session->flash('FO_FILL_UP_POST_SUCCESS_SLUG', $fo->slug);

    }


}