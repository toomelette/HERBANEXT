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



    public function fetch($request){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $manufacturing_orders = $this->cache->remember('manufacturing_orders:fetch:' . $key, 240, function() use ($request, $entries){
            $manufacturing_order = $this->manufacturing_order->newQuery();
            if(isset($request->q)){
                $this->search($manufacturing_order, $request->q);
            }
            return $this->populate($manufacturing_order, $entries);
        });

        return $manufacturing_orders;

    }



    public function store($job_order){

        $manufacturing_order = new ManufacturingOrder;
        $manufacturing_order->slug = $this->str->random(16);
        $manufacturing_order->mo_id = $this->getMOId();
        $manufacturing_order->item_id = $job_order->item_id;
        $manufacturing_order->po_id = $job_order->po_id;
        $manufacturing_order->jo_id = $job_order->jo_id;
        $manufacturing_order->created_at = $this->carbon->now();
        $manufacturing_order->updated_at = $this->carbon->now();
        $manufacturing_order->ip_created = request()->ip();
        $manufacturing_order->ip_updated = request()->ip();
        $manufacturing_order->user_created = $this->auth->user()->user_id;
        $manufacturing_order->user_updated = $this->auth->user()->user_id;
        $manufacturing_order->save();

        return $manufacturing_order;

    }



    public function updateFillUp($request, $slug, $total_weight){

        $manufacturing_order = $this->findBySlug($slug);
        $manufacturing_order->master_mo_no = $request->master_mo_no;
        $manufacturing_order->mo_no = $request->mo_no;
        $manufacturing_order->client = $request->client;
        $manufacturing_order->shelf_life = $request->shelf_life;
        $manufacturing_order->processing_date = $this->__dataType->date_parse($request->processing_date);
        $manufacturing_order->expired_date = $this->__dataType->date_parse($request->expired_date);
        $manufacturing_order->requested_date = $this->__dataType->date_parse($request->requested_date);
        $manufacturing_order->requested_by = $request->requested_by;
        $manufacturing_order->status = $request->status;
        $manufacturing_order->total_weight = $total_weight;
        $manufacturing_order->updated_at = $this->carbon->now();
        $manufacturing_order->ip_updated = request()->ip();
        $manufacturing_order->user_updated = $this->auth->user()->user_id;
        $manufacturing_order->save();

        return $manufacturing_order;

    }



    public function findBySlug($slug){

        $manufacturing_order = $this->cache->remember('manufacturing_orders:findBySlug:' . $slug, 240, function() use ($slug){
            return $this->manufacturing_order->where('slug', $slug)
                                             ->with('manufacturingOrderRawMat', 'jobOrder')
                                             ->first();
        }); 
        if(empty($manufacturing_order)){abort(404);}
        return $manufacturing_order;

    }



    public function findByJOId($jo_id){

        $manufacturing_order = $this->cache->remember('manufacturing_orders:findByJOId:' . $jo_id, 240, function() use ($jo_id){
            return $this->manufacturing_order->where('jo_id', $jo_id)->first();
        }); 
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



    public function search($model, $key){

        return $model->where(function ($model) use ($key) {
                $model->where('mo_no', 'LIKE', '%'. $key .'%')
                      ->orWhere('master_mo_no', 'LIKE', '%'. $key .'%')
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



}