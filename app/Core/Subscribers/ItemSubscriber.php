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
        $events->listen('item.add_batch_remarks', 'App\Core\Subscribers\ItemSubscriber@onAddBatchRemarks');
        $events->listen('item.update_logs_remarks', 'App\Core\Subscribers\ItemSubscriber@onUpdateLogsRemarks');


    }




    public function onStore(){
        
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:getRawMats');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:getPackMats');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:getByItemId:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_batches:fetchByItem:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_batches:getByItemId:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_batches:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_logs:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_logs:fetchByItem:*');

        $this->session->flash('ITEM_CREATE_SUCCESS', 'The Item has been successfully created!');

    }





    public function onUpdate($item){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:getRawMats');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:getPackMats');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:getByItemId:'. $item->item_id .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:findBySlug:'. $item->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:findByItemId:'. $item->item_id .'');

        $this->session->flash('ITEM_UPDATE_SUCCESS', 'The Item has been successfully updated!');
        $this->session->flash('ITEM_UPDATE_SUCCESS_SLUG', $item->slug);

    }



    public function onDestroy($item){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:getRawMats');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:getPackMats');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:getByItemId:'. $item->item_id .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_batches:fetchByItem:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_batches:getByItemId:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_batches:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_logs:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_logs:fetchByItem:*');

        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:findBySlug:'. $item->slug .'');

        $this->session->flash('ITEM_DELETE_SUCCESS', 'The Item has been successfully deleted!');
        $this->session->flash('ITEM_DELETE_SUCCESS_SLUG', $item->slug);

    }





    public function onCheckIn($item){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_batches:fetchByItem:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_batches:getByItemId:'. $item->item_id .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_batches:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_logs:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_logs:fetchByItem:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_logs:getLatest');

        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:findBySlug:'. $item->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:findByItemId:'. $item->item_id .'');

        $this->session->flash('ITEM_CHECK_IN_SUCCESS', 'The Item batch has been successfully check in!');
        $this->session->flash('ITEM_CHECK_IN_SUCCESS_SLUG', $item->slug);

    }





    public function onCheckOut($item){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_batches:fetchByItem:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_batches:getByItemId:'. $item->item_id .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_batches:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_logs:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_logs:fetchByItem:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_logs:checkedOutFinishGoodsCurrentMonth');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_logs:getLatest');
        
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:findBySlug:'. $item->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:items:findByItemId:'. $item->product_code .'');

        $this->session->flash('ITEM_CHECK_OUT_SUCCESS', 'The Amount has been successfully check out!');
        $this->session->flash('ITEM_CHECK_OUT_SUCCESS_SLUG', $item->slug);

    }





    public function onAddBatchRemarks($batch){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_batches:fetchByItem:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_batches:getByItemId:'. $batch->item_id .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_batches:getAll');

        $this->session->flash('ITEM_ADD_BATCH_REMARKS_SUCCESS', 'Remarks Successfully updated!');

    }





    public function onUpdateLogsRemarks($log){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_logs:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:item_logs:fetchByItem:*');

        $this->session->flash('ITEM_LOGS_UPDATE_REMARKS_SUCCESS', 'Record Successfully updated!');
        $this->session->flash('ITEM_LOGS_UPDATE_REMARKS_SUCCESS_ID', $log->id);

    }





}