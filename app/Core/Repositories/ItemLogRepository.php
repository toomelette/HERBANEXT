<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\ItemLogInterface;


use App\Models\ItemLog;


class ItemLogRepository extends BaseRepository implements ItemLogInterface {
	



    protected $item_log;




	public function __construct(ItemLog $item_log){

        $this->item_log = $item_log;
        parent::__construct();

    }





    public function fetch($request){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $item_logs = $this->cache->remember('item_logs:fetch:' . $key, 240, function() use ($request, $entries){

            $item_log = $this->item_log->newQuery();

            $df = $this->__dataType->date_parse($request->df, 'Y-m-d 00:00:00');
            $dt = $this->__dataType->date_parse($request->dt, 'Y-m-d 23:59:00');

            if(isset($request->q)){
                $this->search($item_log, $request->q);
            }
            
            if(isset($request->df) || isset($request->dt)){
                $item_log->where('datetime', '>=', $df)->where('datetime', '<=', $dt);
            }

            return $this->populate($item_log, $entries);

        });

        return $item_logs;

    }






    public function search($model, $key){

        return $model->where(function ($model) use ($key) {
                $model->where('product_code', 'LIKE', '%'. $key .'%')
                      ->orWhere('amount', 'LIKE', '%'. $key .'%')
                      ->orwhereHas('item', function ($model) use ($key) {
                            $model->where('name', 'LIKE', '%'. $key .'%');
                        })
                      ->orwhereHas('user', function ($model) use ($key) {
                            $model->where('username', 'LIKE', '%'. $key .'%');
                        });
        });

    }





    public function populate($model, $entries){

        return $model->select('id', 'batch_id', 'product_code', 'item_name', 'transaction_type', 'amount', 'unit', 'remarks', 'user_id', 'datetime')
                     ->with('item', 'user', 'itemBatch')
                     ->sortable()
                     ->orderBy('datetime', 'desc')
                     ->paginate($entries);

    }





    public function fetchByItem($item_id, $request){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $item_logs = $this->cache->remember('item_logs:fetchByItem:' . $key, 240, function() use ($request, $entries, $item_id){

            $item_log = $this->item_log->newQuery();
            
            if(isset($request->q)){
                $this->searchByItem($item_log, $request->q);
            }

            return $this->populateByItem($item_log, $entries, $item_id);

        });

        return $item_logs;

    }






    public function searchByItem($model, $key){

        return $model->where(function ($model) use ($key) {
                $model->where('product_code', 'LIKE', '%'. $key .'%')
                      ->orWhere('amount', 'LIKE', '%'. $key .'%')
                      ->orwhereHas('user', function ($model) use ($key) {
                            $model->where('username', 'LIKE', '%'. $key .'%');
                        });
        });

    }





    public function populateByItem($model, $entries, $item_id){

        return $model->select('id', 'batch_id', 'transaction_type', 'amount', 'unit', 'remarks', 'user_id', 'datetime')
                     ->with('user', 'itemBatch')
                     ->where('item_id', $item_id)
                     ->sortable()
                     ->orderBy('datetime', 'desc')
                     ->paginate($entries);

    }






    public function storeCheckIn($request, $item, $item_batch){

    	$item_log = new ItemLog;
    	$item_log->product_code = $item->product_code;
        $item_log->item_id = $item->item_id;
        $item_log->batch_id = $item_batch->batch_id;
        $item_log->item_name = $item->name;
    	$item_log->transaction_type = true;
    	$item_log->amount = $this->__dataType->string_to_num($request->amount);
        $item_log->unit = $request->unit;
    	$item_log->balance_before_transaction = $item->current_balance;
        $item_log->remarks = $request->remarks;
        $item_log->datetime = $this->carbon->now();
        $item_log->ip_address = request()->ip();
        $item_log->user_id = $this->auth->user()->user_id;
        $item_log->save();

    	return $item_log;

    }






    public function storeCheckOut($request, $item, $item_batch = null){

        $item_log = new ItemLog;
        $item_log->product_code = $item->product_code;
        $item_log->item_id = $item->item_id;
        $item_log->batch_id = $item_batch ? $item_batch->batch_id : null;
        $item_log->item_name = $item->name;
        $item_log->transaction_type = false;
        $item_log->amount = $this->__dataType->string_to_num($request->amount);
        $item_log->unit = $request->unit;
        $item_log->balance_before_transaction = $item->current_balance;
        $item_log->remarks = $request->remarks;
        $item_log->datetime = $this->carbon->now();
        $item_log->ip_address = request()->ip();
        $item_log->user_id = $this->auth->user()->user_id;
        $item_log->save();

        return $item_log;

    }






    public function updateRemarks($id, $request){
        
        $item_log = ItemLog::where('id', $id)->first();
        $item_log->remarks = $request->remarks;
        $item_log->save();

        return $item_log;

    }





    public function getLatest(){

        $item_logs = $this->cache->remember('item_logs:getLatest', 240, function(){

            return $this->item_log->select('item_id', 'item_name', 'transaction_type', 'amount', 'unit')
                                  ->orderBy('datetime', 'desc')
                                  ->limit(15)
                                  ->get();

        });
        
        return $item_logs;

    }





    public function checkedOutFinishGoodsCurrentMonth(){

        $item_logs = $this->cache->remember('item_logs:checkedOutFinishGoodsCurrentMonth', 240, function(){

            $month_now = $this->carbon->now()->format('m');

            return $this->item_log->select('item_id', 'amount', 'unit')
                                  ->with('item')
                                  ->where('transaction_type', 0)
                                  ->whereMonth('datetime', $month_now)
                                  ->whereHas('item', function ($model){
                                    $model->where('item_category_id', 'IC10005');
                                  })
                                  ->get();

        });
        
        return $item_logs;

    }






}