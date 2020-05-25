<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\DeliveryJOInterface;

use App\Models\DeliveryJO;


class DeliveryJORepository extends BaseRepository implements DeliveryJOInterface {
	


    protected $delivery_jo;



	public function __construct(DeliveryJO $delivery_jo){

        $this->delivery_jo = $delivery_jo;
        parent::__construct();

    }



    public function store($delivery_id, $jo_id){

        $delivery_jo = new DeliveryJO;
        $delivery_jo->delivery_id = $delivery_id;
        $delivery_jo->jo_id = $jo_id;
        $delivery_jo->save();

    }



}