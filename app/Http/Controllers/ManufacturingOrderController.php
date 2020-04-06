<?php

namespace App\Http\Controllers;

use App\Core\Services\ManufacturingOrderService;
use App\Http\Requests\ManufacturingOrder\ManufacturingOrderFilterRequest;
use App\Http\Requests\ManufacturingOrder\ManufacturingOrderFillRequest;


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


    public function fillUpPost(ManufacturingOrderFillRequest $request, $slug){
        return $this->manufacturing_order->fillUpPost($request, $slug);
    }


    public function show($slug){
        return $this->manufacturing_order->show($slug);
    }


    public function print($slug){
        return $this->manufacturing_order->print($slug);
    }


}
