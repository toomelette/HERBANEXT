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





    public function fetchByItem($item_id, $request){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 100;

        $item_batches = $this->cache->remember('item_batches:fetchByItem:' . $key, 240, function() use ($request, $entries, $item_id){

            $item_batch = $this->item_batch->newQuery();
            
            if(isset($request->q)){
                $this->searchByItem($item_batch, $request->q);
            }

            return $this->populateByItem($item_batch, $entries, $item_id);

        });

        return $item_batches;

    }






    public function store($request, $item){

    	$item_batch = new ItemBatch;
        $item_batch->batch_id = $this->getBatchIdInc();
    	$item_batch->product_code = $item->product_code;
        $item_batch->item_id = $item->item_id;
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






    public function updateCheckIn($batch_code, $amount){

        $item_batch = $this->findByBatchCode($batch_code);
        $item_batch->amount = $item_batch->amount + $amount;
        $item_batch->updated_at = $this->carbon->now();
        $item_batch->ip_updated = request()->ip();
        $item_batch->user_updated = $this->auth->user()->user_id;
        $item_batch->save();

        return $item_batch;

    }






    public function updateCheckOut($batch_id, $amount){

        $item_batch = $this->findByBatchId($batch_id);
        $item_batch->amount = $item_batch->amount - $amount;
        $item_batch->updated_at = $this->carbon->now();
        $item_batch->ip_updated = request()->ip();
        $item_batch->user_updated = $this->auth->user()->user_id;
        $item_batch->save();

        return $item_batch;

    }






    public function updateCheckOutByBatchCode($batch_code, $amount){

        $item_batch = $this->findByBatchCode($batch_code);
        $item_batch->amount = $item_batch->amount - $amount;
        $item_batch->updated_at = $this->carbon->now();
        $item_batch->ip_updated = request()->ip();
        $item_batch->user_updated = $this->auth->user()->user_id;
        $item_batch->save();

        return $item_batch;

    }






    public function updateRemarks($batch_id, $remarks){

        $item_batch = $this->findByBatchId($batch_id);
        $item_batch->remarks = $remarks;
        $item_batch->updated_at = $this->carbon->now();
        $item_batch->ip_updated = request()->ip();
        $item_batch->user_updated = $this->auth->user()->user_id;
        $item_batch->save();

        return $item_batch;

    }





    public function findByBatchId($batch_id){

        $item_batch = $this->item_batch->where('batch_id', $batch_id)->first();
        
        if(empty($item_batch)){
            abort(404);
        }

        return $item_batch;

    }





    public function findByBatchCode($batch_code){

        $item_batch = $this->item_batch->where('batch_code', $batch_code)->first();
        
        if(empty($item_batch)){
            abort(404);
        }

        return $item_batch;

    }






    public function searchByItem($model, $key){

        return $model->where(function ($model) use ($key) {
                $model->where('batch_code', 'LIKE', '%'. $key .'%')
                      ->orWhere('amount', 'LIKE', '%'. $key .'%');
        });

    }





    public function populateByItem($model, $entries, $item_id){

        return $model->select('batch_code', 'batch_id', 'amount', 'unit', 'expiry_date', 'remarks', 'updated_at')
                     ->where('item_id', $item_id)
                     ->sortable()
                     ->orderBy('updated_at')
                     ->paginate($entries);

    }






    public function getAll(){

        $item_batches = $this->cache->remember('item_batches:getAll', 240, function(){
            return $this->item_batch->select('item_id', 'batch_code', 'amount', 'expiry_date')
                                    ->with('item')
                                    ->get();
        });
        
        return $item_batches;

    }






    public function getByItemId($item_id){

        $item_batches = $this->cache->remember('item_batches:getByItemId:'.$item_id, 240, function() use ($item_id){
            return $this->item_batch->select('batch_code')
                                    ->where('item_id', $item_id)
                                    ->get();
        });
        
        return $item_batches;

    }





    public function getBatchIdInc(){

        $id = 'B10001';

        $item_batch = $this->item_batch->select('batch_id')->orderBy('batch_id', 'desc')->first();

        if($item_batch != null){

            if($item_batch->batch_id != null){
                $num = str_replace('B', '', $item_batch->batch_id) + 1;
                $id = 'B' . $num;
            }
        
        }
        
        return $id;
        
    }






}