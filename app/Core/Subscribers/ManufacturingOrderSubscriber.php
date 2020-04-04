<?php 

namespace App\Core\Subscribers;


use App\Core\BaseClasses\BaseSubscriber;



class ManufacturingOrderSubscriber extends BaseSubscriber{


    public function __construct(){
        parent::__construct();
    }


    public function subscribe($events){
        $events->listen('manufacturing_order.fill_up_post', 'App\Core\Subscribers\ManufacturingOrderSubscriber@onFillUpPost');
    }


    public function onGenerateFillPost($slug){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:manufacturing_orders:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:manufacturing_orders:findBySlug:'. $slug .'');

        $this->session->flash('MO_FILL_UP_POST_SUCCESS', 'The MO has been successfully posted!');
        $this->session->flash('MO_FILL_UP_POST_SUCCESS_SLUG', $slug);

    }


}