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
            
            if(isset($request->q)){
                $this->search($item_log, $request->q);
            }

            return $this->populate($item_log, $entries);

        });

        return $item_logs;

    }






    public function storeCheckIn($request, $item){

    	$item_log = new ItemLog;
    	$item_log->product_code = $item->product_code;
    	$item_log->transaction_type = true;
    	$item_log->amount = $this->__dataType->string_to_num($request->amount);
        $item_log->unit = $request->unit;
    	$item_log->balance_before_transaction = $item->current_balance;
        $item_log->created_at = $this->carbon->now();
        $item_log->updated_at = $this->carbon->now();
        $item_log->ip_created = request()->ip();
        $item_log->ip_updated = request()->ip();
        $item_log->user_created = $this->auth->user()->user_id;
        $item_log->user_updated = $this->auth->user()->user_id;
        $item_log->save();

    	return $item_log;

    }






    public function storeCheckOut($request, $item){

        $item_log = new ItemLog;
        $item_log->product_code = $item->product_code;
        $item_log->transaction_type = false;
        $item_log->amount = $this->__dataType->string_to_num($request->amount);
        $item_log->unit = $request->unit;
        $item_log->balance_before_transaction = $item->current_balance;
        $item_log->created_at = $this->carbon->now();
        $item_log->updated_at = $this->carbon->now();
        $item_log->ip_created = request()->ip();
        $item_log->ip_updated = request()->ip();
        $item_log->user_created = $this->auth->user()->user_id;
        $item_log->user_updated = $this->auth->user()->user_id;
        $item_log->save();

        return $item_log;

    }






    public function search($model, $key){

        return $model->where(function ($model) use ($key) {
                $model->where('product_code', 'LIKE', '%'. $key .'%');
        });

    }





    public function populate($model, $entries){

        return $model->select('product_code', 'transaction_type', 'amount', 'unit', 'updated_at')
                     ->with('item')
                     ->sortable()
                     ->orderBy('updated_at', 'desc')
                     ->paginate($entries);

    }






}