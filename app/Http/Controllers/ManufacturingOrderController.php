<?php

namespace App\Http\Controllers;

use App\Core\Services\ManufacturingOrderService;
use App\Http\Requests\ManufacturingOrder\ManufacturingOrderFilterRequest;


class ManufacturingOrderController extends Controller{



	protected $manufacturing_order;



    public function __construct(ManufacturingOrderService $manufacturing_order){

        $this->manufacturing_order = $manufacturing_order;

    }



    public function index(ManufacturingOrderFilterRequest $request){
        return $this->manufacturing_order->fetch($request);
    }



    public function fillUp($slug){
        return $this->manufacturing_order->fillUp($slug);
    }

    


}
