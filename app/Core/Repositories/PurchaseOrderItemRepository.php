<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\PurchaseOrderItemInterface;


use App\Models\PurchaseOrderItem;


class PurchaseOrderItemRepository extends BaseRepository implements PurchaseOrderItemInterface {
	



    protected $po_item;




	public function __construct(PurchaseOrderItem $po_item){

        $this->po_item = $po_item;
        parent::__construct();

    }





    public function fetch($request){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $po_items = $this->cache->remember('purchase_order_items:fetch:' . $key, 240, function() use ($request, $entries){

            $po_item = $this->po_item->newQuery();
            
            if(isset($request->q)){
                $this->search($po_item, $request->q);
            }

            return $this->populate($po_item, $entries);

        });

        return $po_items;

    }






    public function store($data, $item, $purchase_order, $line_price){

        $po_item = new PurchaseOrderItem;
        $po_item->slug = $this->str->random(16);
        $po_item->po_item_id = $this->getPOItemId();
        $po_item->po_id = $purchase_order->po_id;
        $po_item->po_no = $purchase_order->po_no;
        $po_item->unit_type_id = $data['unit_type_id'];
        $po_item->item_id = $data['item'];
        $po_item->item_type_id = $item->item_type_id;
        $po_item->item_type_percent = $this->__dataType->string_to_num(optional($item->itemType)->percent);
        $po_item->amount = $this->__dataType->string_to_num($data['amount']);
        $po_item->unit = $data['unit'];
        $po_item->item_price = $item->price;
        $po_item->line_price = $line_price;
        $po_item->delivery_status = 0;
        $po_item->created_at = $this->carbon->now();
        $po_item->updated_at = $this->carbon->now();
        $po_item->ip_created = request()->ip();
        $po_item->ip_updated = request()->ip();
        $po_item->user_created = $this->auth->user()->user_id;
        $po_item->user_updated = $this->auth->user()->user_id;
        $po_item->save();
        
        return $po_item;

    }





    public function updateDeliveryStatus($po_item_id, $int){

        $po_item = $this->findByPOItemId($po_item_id);
        $po_item->delivery_status = $int;
        $po_item->updated_at = $this->carbon->now();
        $po_item->ip_updated = request()->ip();
        $po_item->user_updated = $this->auth->user()->user_id;
        $po_item->save();

        return $po_item;

    }





    public function updateIsGenerated($slug, $int){

        $po_item = $this->findBySlug($slug);
        $po_item->is_generated = $int;
        $po_item->updated_at = $this->carbon->now();
        $po_item->ip_updated = request()->ip();
        $po_item->user_updated = $this->auth->user()->user_id;
        $po_item->save();

        return $po_item;

    }





    public function findBySlug($slug){

        $po_item = $this->cache->remember('purchase_order_items:findBySlug:' . $slug, 240, function() use ($slug){
            return $this->po_item->where('slug', $slug)->with('jobOrder')->first();
        }); 
        
        if(empty($po_item)){ abort(404); }

        return $po_item;

    }





    public function findByPOItemId($po_item_id){

        $po_item = $this->cache->remember('purchase_order_items:findByPOItemId:' . $po_item_id, 240, function() use ($po_item_id){
            return $this->po_item->where('po_item_id', $po_item_id)->first();
        }); 
        
        if(empty($po_item)){ abort(404); }

        return $po_item;

    }






    public function search($model, $key){

        return $model->where(function ($model) use ($key) {
                $model->where('po_no', 'LIKE', '%'. $key .'%')
                      ->orwhereHas('item', function ($model) use ($key) {
                        $model->where('name', 'LIKE', '%'. $key .'%')
                              ->orWhere('product_code', 'LIKE', '%'. $key .'%');
                      });
        });

    }





    public function populate($model, $entries){

        return $model->select('po_id', 'po_item_id', 'po_no', 'item_id', 'amount', 'unit', 'updated_at', 'is_generated', 'slug')
                     ->whereHas('purchaseOrder', function($query) {
                        $query->whereIn('process_status', [1,2]);
                     })
                     ->sortable()
                     ->orderBy('updated_at', 'desc')
                     ->paginate($entries);

    }






    public function getAll(){

        $po_items = $this->cache->remember('purchase_order_items:getAll', 240, function(){
            return $this->po_item->select('po_id', 'po_item_id', 'po_no', 'item_id', 'delivery_status', 'is_generated')
                                 ->with('purchaseOrder', 'item')
                                 ->orderBy('updated_at', 'asc')
                                 ->get();
        });
        
        return $po_items;

    }





    public function getPOItemId(){

        $id = 'POI10001';

        $po_item = $this->po_item->select('po_item_id')->orderBy('po_item_id', 'desc')->first();

        if($po_item != null){
            $num = str_replace('POI', '', $po_item->po_item_id) + 1;
            $id = 'POI' . $num;
        }
        
        return $id;
        
    }






}