<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\ItemBatchInterface;


use App\Models\ItemBatch;


class ItemBatchRepository extends BaseRepository implements ItemBatchInterface {
	



    protected $item_batch;




	public function __construct(ItemBatch $item_batch){

        $this->item_batch = $item_batch;
        parent::__construct();

    }






    public function store($request, $item){

    	$item_batch = new ItemBatch;
    	$item_batch->product_code = $item->product_code;
    	$item_batch->batch_code = $request->batch_code;
    	$item_batch->amount = $this->__dataType->string_to_num($request->amount);
        $item_batch->unit = $request->unit;
    	$item_batch->expiry_date = $this->__dataType->date_parse($request->expiry_date);
        $item_batch->created_at = $this->carbon->now();
        $item_batch->updated_at = $this->carbon->now();
        $item_batch->ip_created = request()->ip();
        $item_batch->ip_updated = request()->ip();
        $item_batch->user_created = $this->auth->user()->user_id;
        $item_batch->user_updated = $this->auth->user()->user_id;
        $item_batch->save();

    	return $item_batch;

    }






    public function updateCheckOut($batch_code, $amount){

        $item_batch = $this->findByBatchCode($batch_code);
        $item_batch->amount = $item_batch->amount - $amount;
        $item_batch->save();

        return $item_batch;

    }





    public function findByBatchCode($batch_code){

        $item_batch = $this->item_batch->where('batch_code', $batch_code)->first();
        
        if(empty($item_batch)){
            abort(404);
        }

        return $item_batch;

    }






}