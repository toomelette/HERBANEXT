<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\JobOrderInterface;

use App\Models\JobOrder;


class JobOrderRepository extends BaseRepository implements JobOrderInterface {
	


    protected $job_order;



	public function __construct(JobOrder $job_order){

        $this->job_order = $job_order;
        parent::__construct();

    }





    public function store($request, $purchase_order_item, $batch_size){

        $job_order = new JobOrder;
        $job_order->slug = $this->str->random(16);
        $job_order->jo_id = $this->getJOId();
        $job_order->jo_no = $request->jo_no;
        $job_order->po_item_id = $purchase_order_item->po_item_id;
        $job_order->po_id = $purchase_order_item->po_id;
        $job_order->po_no = $purchase_order_item->po_no;
        $job_order->item_name = optional($purchase_order_item->item)->name;
        $job_order->batch_size = $batch_size;
        $job_order->batch_size_unit = $purchase_order_item->unit;
        $job_order->amount = $purchase_order_item->amount;
        $job_order->unit = $purchase_order_item->unit;
        $job_order->created_at = $this->carbon->now();
        $job_order->updated_at = $this->carbon->now();
        $job_order->ip_created = request()->ip();
        $job_order->ip_updated = request()->ip();
        $job_order->user_created = $this->auth->user()->user_id;
        $job_order->user_updated = $this->auth->user()->user_id;
        $job_order->save();

    }





    public function getJOId(){

        $id = 'JO10001';

        $job_order = $this->job_order->select('jo_id')->orderBy('jo_id', 'desc')->first();

        if($job_order != null){
            $num = str_replace('JO', '', $job_order->jo_id) + 1;
            $id = 'JO' . $num;
        }
        
        return $id;
        
    }






}