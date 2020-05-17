<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\FinishingOrderInterface;

use App\Models\FinishingOrder;


class FinishingOrderRepository extends BaseRepository implements FinishingOrderInterface {
	


    protected $finishing_order;



	public function __construct(FinishingOrder $finishing_order){

        $this->finishing_order = $finishing_order;
        parent::__construct();

    }



    public function fetch($request){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $finishing_orders = $this->cache->remember('finishing_orders:fetch:' . $key, 240, function() use ($request, $entries){
            $finishing_order = $this->finishing_order->newQuery();
            if(isset($request->q)){
                $this->search($finishing_order, $request->q);
            }
            return $this->populate($finishing_order, $entries);
        });

        return $finishing_orders;

    }



    public function store($job_order){

        $finishing_order = new FinishingOrder;
        $finishing_order->slug = $this->str->random(16);
        $finishing_order->fo_id = $this->getFOId();
        $finishing_order->item_id = $job_order->item_id;
        $finishing_order->po_id = $job_order->po_id;
        $finishing_order->jo_id = $job_order->jo_id;
        $finishing_order->created_at = $this->carbon->now();
        $finishing_order->updated_at = $this->carbon->now();
        $finishing_order->ip_created = request()->ip();
        $finishing_order->ip_updated = request()->ip();
        $finishing_order->user_created = $this->auth->user()->user_id;
        $finishing_order->user_updated = $this->auth->user()->user_id;
        $finishing_order->save();

        return $finishing_order;

    }



    public function updateFillUpFromMO($request, $jo_id){

        $finishing_order = $this->findByJOId($jo_id);
        $finishing_order->client = $request->client;
        $finishing_order->shelf_life = $request->shelf_life;
        $finishing_order->processing_date = $this->__dataType->date_parse($request->processing_date);
        $finishing_order->expired_date = $this->__dataType->date_parse($request->expired_date);
        $finishing_order->requested_date = $this->__dataType->date_parse($request->requested_date);
        $finishing_order->requested_by = $request->requested_by;
        $finishing_order->status = $request->status;
        $finishing_order->updated_at = $this->carbon->now();
        $finishing_order->ip_updated = request()->ip();
        $finishing_order->user_updated = $this->auth->user()->user_id;
        $finishing_order->save();

        return $finishing_order;

    }



    public function updateFillUp($request, $slug){

        $finishing_order = $this->findBySlug($slug);
        $finishing_order->master_fo_no = $request->master_fo_no;
        $finishing_order->fo_no = $request->fo_no;
        $finishing_order->client = $request->client;
        $finishing_order->shelf_life = $request->shelf_life;
        $finishing_order->processing_date = $this->__dataType->date_parse($request->processing_date);
        $finishing_order->expired_date = $this->__dataType->date_parse($request->expired_date);
        $finishing_order->requested_date = $this->__dataType->date_parse($request->requested_date);
        $finishing_order->requested_by = $request->requested_by;
        $finishing_order->status = $request->status;
        $finishing_order->updated_at = $this->carbon->now();
        $finishing_order->ip_updated = request()->ip();
        $finishing_order->user_updated = $this->auth->user()->user_id;
        $finishing_order->save();

        return $finishing_order;

    }



    public function findBySlug($slug){

        $finishing_order = $this->cache->remember('finishing_orders:findBySlug:' . $slug, 240, function() use ($slug){
            return $this->finishing_order->where('slug', $slug)
                                         ->with('finishingOrderPackMat', 'jobOrder')
                                         ->first();
        }); 
        if(empty($finishing_order)){abort(404);}
        return $finishing_order;

    }



    public function findByJOId($jo_id){
        
        $finishing_order = $this->cache->remember('finishing_orders:findByJOId:' . $jo_id, 240, function() use ($jo_id){
            return $this->finishing_order->where('jo_id', $jo_id)->first();
        }); 

        return $finishing_order;

    }



    public function search($model, $key){

        return $model->where(function ($model) use ($key) {
                $model->where('fo_no', 'LIKE', '%'. $key .'%')
                      ->orWhere('master_fo_no', 'LIKE', '%'. $key .'%')
                      ->orwhereHas('jobOrder', function ($model) use ($key) {
                        $model->where('jo_no', 'LIKE', '%'. $key .'%')
                              ->orWhere('po_no', 'LIKE', '%'. $key .'%')
                              ->orWhere('item_product_code', 'LIKE', '%'. $key .'%')
                              ->orWhere('item_name', 'LIKE', '%'. $key .'%');
                      });
        });

    }



    public function populate($model, $entries){

        return $model->select('jo_id', 'updated_at', 'slug')
                     ->with('jobOrder')
                     ->sortable()
                     ->orderBy('updated_at', 'desc')
                     ->paginate($entries);

    }



    public function getFOId(){

        $id = 'FO100001';
        $finishing_order = $this->finishing_order->select('fo_id')->orderBy('fo_id', 'desc')->first();

        if($finishing_order != null){
            $num = str_replace('FO', '', $finishing_order->fo_id) + 1;
            $id = 'FO' . $num;
        }
        
        return $id;
        
    }



}