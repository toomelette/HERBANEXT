<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\DeliveryItemInterface;

use App\Models\DeliveryItem;


class DeliveryItemRepository extends BaseRepository implements DeliveryItemInterface {
	


    protected $delivery_item;



	public function __construct(DeliveryItem $delivery_item){

        $this->delivery_item = $delivery_item;
        parent::__construct();

    }



    public function store($delivery_id, $po_item_id){

        $delivery_item = new DeliveryItem;
        $delivery_item->delivery_id = $delivery_id;
        $delivery_item->po_item_id = $po_item_id;
        $delivery_item->save();

    }



}