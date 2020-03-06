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
        $entries = isset($request->e) ? $request->e : 100;

        $item_logs = $this->cache->remember('item_logs:fetch:' . $key, 240, function() use ($request, $entries){

            $item_log = $this->item_log->newQuery();

            $df = $this->__dataType->date_parse($request->df, 'Y-m-d 00:00:00');
            $dt = $this->__dataType->date_parse($request->dt, 'Y-m-d 24:00:00');

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





    public function fetchByItem($item_id, $request){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 100;

        $item_logs = $this->cache->remember('item_logs:fetchByItem:' . $key, 240, function() use ($request, $entries, $item_id){

            $item_log = $this->item_log->newQuery();
            
            if(isset($request->q)){
                $this->searchByItem($item_log, $request->q);
            }

            return $this->populateByItem($item_log, $entries, $item_id);

        });

        return $item_logs;

    }






    public function storeCheckIn($request, $item){

    	$item_log = new ItemLog;
    	$item_log->product_code = $item->product_code;
        $item_log->item_id = $item->item_id;
        $item_log->item_name = $item->name;
    	$item_log->transaction_type = true;
    	$item_log->amount = $this->__dataType->string_to_num($request->amount);
        $item_log->unit = $request->unit;
    	$item_log->balance_before_transaction = $item->current_balance;
        $item_log->datetime = $this->carbon->now();
        $item_log->ip_address = request()->ip();
        $item_log->user_id = $this->auth->user()->user_id;
        $item_log->save();

    	return $item_log;

    }






    public function storeCheckOut($request, $item){

        $item_log = new ItemLog;
        $item_log->product_code = $item->product_code;
        $item_log->item_id = $item->item_id;
        $item_log->item_name = $item->name;
        $item_log->transaction_type = false;
        $item_log->amount = $this->__dataType->string_to_num($request->amount);
        $item_log->unit = $request->unit;
        $item_log->balance_before_transaction = $item->current_balance;
        $item_log->datetime = $this->carbon->now();
        $item_log->ip_address = request()->ip();
        $item_log->user_id = $this->auth->user()->user_id;
        $item_log->save();
        $item_log->save();

        return $item_log;

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






    public function searchByItem($model, $key){

        return $model->where(function ($model) use ($key) {
                $model->where('product_code', 'LIKE', '%'. $key .'%')
                      ->orWhere('amount', 'LIKE', '%'. $key .'%')
                      ->orwhereHas('user', function ($model) use ($key) {
                            $model->where('username', 'LIKE', '%'. $key .'%');
                        });
        });

    }





    public function populate($model, $entries){

        return $model->select('product_code', 'item_name', 'transaction_type', 'amount', 'unit', 'user_id', 'datetime')
                     ->with('item', 'user')
                     ->sortable()
                     ->orderBy('datetime', 'desc')
                     ->paginate($entries);

    }





    public function populateByItem($model, $entries, $item_id){

        return $model->select('transaction_type', 'amount', 'unit', 'user_id', 'datetime')
                     ->with('user')
                     ->where('item_id', $item_id)
                     ->sortable()
                     ->orderBy('datetime', 'desc')
                     ->paginate($entries);

    }






}