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






    public function store($data, $item, $purchase_order, $line_price){

        $po_item = new PurchaseOrderItem;
        $po_item->slug = $this->str->random(16);
        $po_item->po_item_id = $this->getPOItemId();
        $po_item->po_id = $purchase_order->po_id;
        $po_item->po_no = $purchase_order->po_no;
        $po_item->unit_type_id = $data['unit_type_id'];
        $po_item->item_id = $data['item'];
        $po_item->amount = $this->__dataType->string_to_num($data['amount']);
        $po_item->unit = $data['unit'];
        $po_item->item_price = $item->price;
        $po_item->line_price = $line_price;
        $po_item->save();
        
        return $po_item;

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