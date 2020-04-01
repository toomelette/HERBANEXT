<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\ManufacturingOrderInterface;

use App\Models\ManufacturingOrder;


class ManufacturingOrderRepository extends BaseRepository implements ManufacturingOrderInterface {
	


    protected $manufacturing_order;



	public function __construct(ManufacturingOrder $manufacturing_order){

        $this->manufacturing_order = $manufacturing_order;
        parent::__construct();

    }




    public function store($job_order){

        $manufacturing_order = new ManufacturingOrder;
        $manufacturing_order->slug = $this->str->random(16);
        $manufacturing_order->mo_id = $this->getMOId();
        $manufacturing_order->item_id = $job_order->item_id;
        $manufacturing_order->item_product_code = optional($job_order->item)->product_code;
        $manufacturing_order->item_type_id = optional($job_order->item)->item_type_id;
        $manufacturing_order->item_name = $job_order->item_name;
        $manufacturing_order->po_id = $job_order->po_id;
        $manufacturing_order->jo_id = $job_order->jo_id;
        $manufacturing_order->jo_batch_size = $job_order->batch_size;
        $manufacturing_order->jo_batch_size_unit = $job_order->batch_size_unit;
        $manufacturing_order->jo_pack_size = $job_order->pack_size;
        $manufacturing_order->jo_pack_size_unit = $job_order->pack_size_unit;
        $manufacturing_order->jo_pack_size_pkging = $job_order->pack_size_pkging;
        $manufacturing_order->jo_theo_yield = $job_order->theo_yield;
        $manufacturing_order->jo_theo_yield_pkging = $job_order->theo_yield_pkging;
        $manufacturing_order->created_at = $this->carbon->now();
        $manufacturing_order->updated_at = $this->carbon->now();
        $manufacturing_order->ip_created = request()->ip();
        $manufacturing_order->ip_updated = request()->ip();
        $manufacturing_order->user_created = $this->auth->user()->user_id;
        $manufacturing_order->user_updated = $this->auth->user()->user_id;
        $manufacturing_order->save();

        return $manufacturing_order;

    }





    public function getMOId(){

        $id = 'MO100001';
        $manufacturing_order = $this->manufacturing_order->select('mo_id')->orderBy('mo_id', 'desc')->first();

        if($manufacturing_order != null){
            $num = str_replace('MO', '', $manufacturing_order->mo_id) + 1;
            $id = 'MO' . $num;
        }
        
        return $id;
        
    }




}