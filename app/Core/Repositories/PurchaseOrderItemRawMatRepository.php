<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\PurchaseOrderItemRawMatInterface;
use App\Models\PurchaseOrderItemRawMat;


class PurchaseOrderItemRawMatRepository extends BaseRepository implements PurchaseOrderItemRawMatInterface {
	



    protected $po_item_raw_mat;




	public function __construct(PurchaseOrderItemRawMat $po_item_raw_mat){

        $this->po_item_raw_mat = $po_item_raw_mat;
        parent::__construct();

    }





    public function store($purchase_order, $po_item_id, $item_raw_mat){

        $po_item_raw_mat = new PurchaseOrderItemRawMat;
        $po_item_raw_mat->slug = $this->str->random(16);
        $po_item_raw_mat->po_no = $purchase_order->po_no;
        $po_item_raw_mat->po_id = $purchase_order->po_id;
        $po_item_raw_mat->po_item_id = $po_item_id;
        $po_item_raw_mat->item_raw_mat_id = $item_raw_mat->item_raw_mat_id;
        $po_item_raw_mat->name = $item_raw_mat->name;
        $po_item_raw_mat->created_at = $this->carbon->now();
        $po_item_raw_mat->updated_at = $this->carbon->now();
        $po_item_raw_mat->ip_created = request()->ip();
        $po_item_raw_mat->ip_updated = request()->ip();
        $po_item_raw_mat->user_created = $this->auth->user()->user_id;
        $po_item_raw_mat->user_updated = $this->auth->user()->user_id;
        $po_item_raw_mat->save();
        
        return $po_item_raw_mat;

    }





}