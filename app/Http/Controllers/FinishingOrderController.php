<?php

namespace App\Http\Controllers;

use App\Core\Services\FinishingOrderService;
use App\Http\Requests\FinishingOrder\FinishingOrderFilterRequest;
use App\Http\Requests\FinishingOrder\FinishingOrderFillRequest;


class FinishingOrderController extends Controller{


	protected $finishing_order;


    public function __construct(FinishingOrderService $finishing_order){
        $this->finishing_order = $finishing_order;
    }


    public function index(FinishingOrderFilterRequest $request){
        return $this->finishing_order->fetch($request);
    }


    public function fillUp($slug){
        return $this->finishing_order->fillUp($slug);
    }


    public function fillUpPost(FinishingOrderFillRequest $request, $slug){
        return $this->finishing_order->fillUpPost($request, $slug);
    }


    public function show($slug){
        return $this->finishing_order->show($slug);
    }


    public function print($slug){
        return $this->finishing_order->print($slug);
    }


}
