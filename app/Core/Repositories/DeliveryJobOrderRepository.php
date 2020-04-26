<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\DeliveryJobOrderInterface;

use App\Models\DeliveryJobOrder;


class DeliveryJobOrderRepository extends BaseRepository implements DeliveryJobOrderInterface {
	


    protected $delivery_jo;



	public function __construct(DeliveryJobOrder $delivery_jo){

        $this->delivery_jo = $delivery_jo;
        parent::__construct();

    }



    public function store($delivery_id, $jo_id){

        $delivery_jo = new DeliveryJobOrder;
        $delivery_jo->delivery_id = $delivery_id;
        $delivery_jo->jo_id = $jo_id;
        $delivery_jo->save();

    }



}