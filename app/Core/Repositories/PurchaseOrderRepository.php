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
        $purchase_order->po_no = $this->getPONoInc();
        $purchase_order->slug = $this->str->random(16);
        $purchase_order->bill_to_name = $request->bill_to_name;
        $purchase_order->bill_to_company = $request->bill_to_company;
        $purchase_order->bill_to_address = $request->bill_to_address;
        $purchase_order->ship_to_name = $request->ship_to_name;
        $purchase_order->ship_to_company = $request->ship_to_company;
        $purchase_order->ship_to_address = $request->ship_to_address;
        $purchase_order->process_status = 1;
        $purchase_order->buffer_status = $this->__dataType->string_to_boolean($request->buffer_status);
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

        $purchase_order->purchaseOrderItem()->delete();
        
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

        return $purchase_order;

    }





    public function toProcess($slug){

        $purchase_order = $this->findBySlug($slug);
        $purchase_order->buffer_status = 0;
        $purchase_order->updated_at = $this->carbon->now();
        $purchase_order->ip_updated = request()->ip();
        $purchase_order->user_updated = $this->auth->user()->user_id;
        $purchase_order->save();

        return $purchase_order;

    }





    public function toBuffer($slug){

        $purchase_order = $this->findBySlug($slug);
        $purchase_order->buffer_status = 1;
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

        return $model->select('po_no', 'bill_to_name', 'bill_to_company', 'bill_to_address', 'ship_to_name', 'ship_to_company', 'ship_to_address', 'created_at', 'slug')
                     ->where('buffer_status', 0)
                     ->sortable()
                     ->orderBy('updated_at', 'desc')
                     ->paginate($entries);

    }





    public function populateBuffer($model, $entries){

        return $model->select('po_no', 'bill_to_name', 'bill_to_company', 'bill_to_address', 'ship_to_name', 'ship_to_company', 'ship_to_address', 'created_at', 'slug')
                     ->where('buffer_status', 1)
                     ->sortable()
                     ->orderBy('updated_at', 'desc')
                     ->paginate($entries);

    }






    public function getPONoInc(){

        
        $current_year = $this->carbon->now()->format('Y');
        $date_from = $current_year .'-01-01';
        $date_to = $current_year .'-12-31';

        $po_no = $current_year . "-001";

        $purchase_order = $this->purchase_order->select('po_no')
                                               ->whereBetween('created_at', [$date_from, $date_to])
                                               ->orderBy('po_no', 'desc')
                                               ->first();

        if($purchase_order != null){
            $num = str_replace($current_year .'-', '', $purchase_order->po_no) + 1;
            $po_no = $current_year . '-00' . $num;
        }

        return $po_no;
        
    }






}