<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\PurchaseOrderInterface;
use App\Models\PurchaseOrder;


class PurchaseOrderRepository extends BaseRepository implements PurchaseOrderInterface {
	


    protected $purchase_order;



	public function __construct(PurchaseOrder $purchase_order){

        $this->purchase_order = $purchase_order;
        parent::__construct();

    }



    public function fetch($request){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $purchase_orders = $this->cache->remember('purchase_orders:fetch:' . $key, 240, function() use ($request, $entries){

            $purchase_order = $this->purchase_order->newQuery();

            $df = $this->__dataType->date_parse($request->df, 'Y-m-d 00:00:00');
            $dt = $this->__dataType->date_parse($request->dt, 'Y-m-d 24:00:00');
            
            if(isset($request->q)){
                $this->search($purchase_order, $request->q);
            }
            
            if(isset($request->df) || isset($request->dt)){
                $purchase_order->where('created_at', '>=', $df)->where('created_at', '<=', $dt);
            }

            return $this->populate($purchase_order, $entries);

        });

        return $purchase_orders;

    }



    public function fetchBuffer($request){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $purchase_orders = $this->cache->remember('purchase_orders:fetchBuffer:' . $key, 240, function() use ($request, $entries){

            $purchase_order = $this->purchase_order->newQuery();

            $df = $this->__dataType->date_parse($request->df, 'Y-m-d 00:00:00');
            $dt = $this->__dataType->date_parse($request->dt, 'Y-m-d 24:00:00');
            
            if(isset($request->q)){
                $this->search($purchase_order, $request->q);
            }
            
            if(isset($request->df) || isset($request->dt)){
                $purchase_order->where('created_at', '>=', $df)->where('created_at', '<=', $dt);
            }

            return $this->populateBuffer($purchase_order, $entries);

        });

        return $purchase_orders;

    }



    public function store($request){

        $purchase_order = new PurchaseOrder;
        $purchase_order->po_id = $this->getPOIdInc();
        $purchase_order->po_no = $request->po_no;
        $purchase_order->date_required = $this->__dataType->date_parse($request->date_required);
        $purchase_order->slug = $this->str->random(16);
        $purchase_order->bill_to_name = $request->bill_to_name;
        $purchase_order->bill_to_company = $request->bill_to_company;
        $purchase_order->bill_to_address = $request->bill_to_address;
        $purchase_order->ship_to_name = $request->ship_to_name;
        $purchase_order->ship_to_company = $request->ship_to_company;
        $purchase_order->ship_to_address = $request->ship_to_address;
        
        // for process
        if ($request->type == '1') {
            $purchase_order->process_status = 1;
            $purchase_order->type = 1;
        // subject for delivery
        }elseif($request->type == '2'){
            $purchase_order->process_status = 3;
            $purchase_order->type = 1;
        // for buffer
        }elseif($request->type == '3'){
            $purchase_order->process_status = 1;
            $purchase_order->type = 2;
        }

        $purchase_order->vat = $this->__dataType->string_to_num($request->vat);
        $purchase_order->freight_fee = $this->__dataType->string_to_num($request->freight_fee);
        $purchase_order->instructions = $request->instructions;
        $purchase_order->created_at = $this->carbon->now();
        $purchase_order->updated_at = $this->carbon->now();
        $purchase_order->ip_created = request()->ip();
        $purchase_order->ip_updated = request()->ip();
        $purchase_order->user_created = $this->auth->user()->user_id;
        $purchase_order->user_updated = $this->auth->user()->user_id;
        $purchase_order->save();
        
        return $purchase_order;

    }



    public function update($request, $slug){

        $purchase_order = $this->findBySlug($slug);
        $purchase_order->po_no = $request->po_no;
        $purchase_order->date_required = $this->__dataType->date_parse($request->date_required);
        $purchase_order->bill_to_name = $request->bill_to_name;
        $purchase_order->bill_to_company = $request->bill_to_company;
        $purchase_order->bill_to_address = $request->bill_to_address;
        $purchase_order->ship_to_name = $request->ship_to_name;
        $purchase_order->ship_to_company = $request->ship_to_company;
        $purchase_order->ship_to_address = $request->ship_to_address;
        $purchase_order->vat = $this->__dataType->string_to_num($request->vat);
        $purchase_order->freight_fee = $this->__dataType->string_to_num($request->freight_fee);
        $purchase_order->instructions = $request->instructions;
        $purchase_order->updated_at = $this->carbon->now();
        $purchase_order->ip_updated = request()->ip();
        $purchase_order->user_updated = $this->auth->user()->user_id;
        $purchase_order->save();
        
        return $purchase_order;

    }



    public function updatePrices($purchase_order, $subtotal_price, $total_price){
        
        $purchase_order->subtotal_price = $subtotal_price;
        $purchase_order->total_price = $total_price;
        $purchase_order->updated_at = $this->carbon->now();
        $purchase_order->ip_updated = request()->ip();
        $purchase_order->user_updated = $this->auth->user()->user_id;
        $purchase_order->save();   

        return $purchase_order;

    }



    public function destroy($slug){

        $purchase_order = $this->findBySlug($slug);
        $purchase_order->delete();
        $purchase_order->purchaseOrderItem()->delete();
        $purchase_order->purchaseOrderItemRawMat()->delete();
        $purchase_order->purchaseOrderItemPackMat()->delete();
        $purchase_order->jobOrder()->delete();

        foreach ($purchase_order->manufacturingOrder as $mo) {
            $mo->manufacturingOrderRawMat()->delete();
        }

        $purchase_order->manufacturingOrder()->delete();

        foreach ($purchase_order->finishingOrder as $fo) {
            $fo->finishingOrderPackMat()->delete();
        }

        $purchase_order->finishingOrder()->delete();

        return $purchase_order;

    }



    public function updateType($slug, $int){

        $purchase_order = $this->findBySlug($slug);
        $purchase_order->type = $int;
        $purchase_order->updated_at = $this->carbon->now();
        $purchase_order->ip_updated = request()->ip();
        $purchase_order->user_updated = $this->auth->user()->user_id;
        $purchase_order->save();

        return $purchase_order;

    }



    public function updateProcessStatus($slug, $int){

        $purchase_order = $this->findBySlug($slug);
        $purchase_order->process_status = $int;
        $purchase_order->updated_at = $this->carbon->now();
        $purchase_order->ip_updated = request()->ip();
        $purchase_order->user_updated = $this->auth->user()->user_id;
        $purchase_order->save();

        return $purchase_order;

    }



    public function findBySlug($slug){

        $purchase_order = $this->cache->remember('purchase_orders:findBySlug:' . $slug, 240, function() use ($slug){
            return $this->purchase_order->where('slug', $slug)
                                        ->with('purchaseOrderItem', 'purchaseOrderItem.purchaseOrderItemRawMat', 'purchaseOrderItem.purchaseOrderItemPackMat')
                                        ->first();
        }); 
        
        if(empty($purchase_order)){
            abort(404);
        }

        return $purchase_order;

    }



    public function getCurrentMonth(){

        $purchase_order = $this->cache->remember('purchase_orders:getCurrentMonth', 240, function(){

            return $this->purchase_order->select('po_no', 'bill_to_name', 'bill_to_company', 'bill_to_address', 'ship_to_name', 'ship_to_company', 'ship_to_address', 'process_status')
                                        ->limit(5)
                                        ->orderBy('updated_at', 'desc')
                                        ->get();

        }); 

        return $purchase_order;

    }



    public function search($model, $key){

        return $model->where(function ($model) use ($key) {
                $model->where('po_no', 'LIKE', '%'. $key .'%')
                      ->orWhere('bill_to_name', 'LIKE', '%'. $key .'%')
                      ->orWhere('bill_to_company', 'LIKE', '%'. $key .'%')
                      ->orWhere('bill_to_address', 'LIKE', '%'. $key .'%')
                      ->orWhere('ship_to_name', 'LIKE', '%'. $key .'%')
                      ->orWhere('ship_to_company', 'LIKE', '%'. $key .'%')
                      ->orWhere('ship_to_address', 'LIKE', '%'. $key .'%');
        });

    }



    public function populate($model, $entries){

        return $model->select('po_id', 'po_no', 'bill_to_name', 'bill_to_company', 'bill_to_address', 'ship_to_name', 'ship_to_company', 'ship_to_address', 'type', 'created_at','process_status', 'slug')
                     ->with('purchaseOrderItem')
                     ->where('type', 1)
                     ->sortable()
                     ->orderBy('updated_at', 'desc')
                     ->paginate($entries);

    }



    public function populateBuffer($model, $entries){

        return $model->select('po_no', 'bill_to_name', 'bill_to_company', 'bill_to_address', 'ship_to_name', 'ship_to_company', 'ship_to_address', 'created_at', 'slug')
                     ->where('type', 2)
                     ->sortable()
                     ->orderBy('updated_at', 'desc')
                     ->paginate($entries);

    }



    public function countNew(){

        $purchase_order = $this->cache->remember('purchase_orders:countNew', 240, function(){

            $date_now = $this->carbon->now()->format('Y-m-d');

            return $this->purchase_order->whereDate('created_at', $date_now)->count();
        
        }); 

        return $purchase_order;

    }



    public function getPOIdInc(){

        $id = 'PO10001';
        $purchase_order = $this->purchase_order->select('po_id')->orderBy('po_id', 'desc')->first();

        if($purchase_order != null){
            if($purchase_order->po_id != null){
                $num = str_replace('PO', '', $purchase_order->po_id) + 1;
                $id = 'PO' . $num;
            }
        }
        
        return $id;
        
    }





}