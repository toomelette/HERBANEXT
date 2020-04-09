<?php

namespace App\Http\Controllers;

use App\Core\Services\FinishingOrderService;
use App\Http\Requests\FinishingOrder\FinishingOrderFilterRequest;
use App\Http\Requests\FinishingOrder\FinishingOrderFillRequest;


class FinishingOrderController extends Controller{


	protected $Finishing_order;


    public function __construct(FinishingOrderService $Finishing_order){
        $this->Finishing_order = $Finishing_order;
    }


    // public function index(FinishingOrderFilterRequest $request){
    //     return $this->Finishing_order->fetch($request);
    // }


    // public function fillUp($slug){
    //     return $this->Finishing_order->fillUp($slug);
    // }


    // public function fillUpPost(FinishingOrderFillRequest $request, $slug){
    //     return $this->Finishing_order->fillUpPost($request, $slug);
    // }


    // public function show($slug){
    //     return $this->Finishing_order->show($slug);
    // }


    // public function print($slug){
    //     return $this->Finishing_order->print($slug);
    // }


}
