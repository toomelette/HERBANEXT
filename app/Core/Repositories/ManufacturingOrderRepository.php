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







}