<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\PurchaseOrderItemPackMatInterface;
use App\Models\PurchaseOrderItemPackMat;


class PurchaseOrderItemPackMatRepository extends BaseRepository implements PurchaseOrderItemPackMatInterface {
	



    protected $po_item_pack_mat;




	public function __construct(PurchaseOrderItemPackMat $po_item_pack_mat){

        $this->po_item_pack_mat = $po_item_pack_mat;
        parent::__construct();

    }





    public function store($purchase_order, $po_item_id, $item_pack_mat){

        $po_item_pack_mat = new PurchaseOrderItemPackMat;
        $po_item_pack_mat->slug = $this->str->random(16);
        $po_item_pack_mat->po_no = $purchase_order->po_no;
        $po_item_pack_mat->po_id = $purchase_order->po_id;
        $po_item_pack_mat->po_item_id = $po_item_id;
        $po_item_pack_mat->item_pack_mat_id = $item_pack_mat->item_pack_mat_id;
        $po_item_pack_mat->name = $item_pack_mat->name;
        $po_item_pack_mat->description = $item_pack_mat->description;
        $po_item_pack_mat->created_at = $this->carbon->now();
        $po_item_pack_mat->updated_at = $this->carbon->now();
        $po_item_pack_mat->ip_created = request()->ip();
        $po_item_pack_mat->ip_updated = request()->ip();
        $po_item_pack_mat->user_created = $this->auth->user()->user_id;
        $po_item_pack_mat->user_updated = $this->auth->user()->user_id;
        $po_item_pack_mat->save();
        
        return $po_item_pack_mat;

    }





}