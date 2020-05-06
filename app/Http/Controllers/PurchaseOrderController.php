<?php

namespace App\Http\Controllers;

use App\Core\Services\PurchaseOrderService;
use App\Http\Requests\PurchaseOrder\PurchaseOrderFormRequest;
use App\Http\Requests\PurchaseOrder\PurchaseOrderFilterRequest;

class PurchaseOrderController extends Controller{


	protected $purchase_order;


    public function __construct(PurchaseOrderService $purchase_order){
        $this->purchase_order = $purchase_order;
    }


    public function index(PurchaseOrderFilterRequest $request){
        return $this->purchase_order->fetch($request);
    }

    
    public function create(){
        return view('dashboard.purchase_order.create');
    }


    public function store(PurchaseOrderFormRequest $request){
        return $this->purchase_order->store($request);
    }
 

    public function edit($slug){
        return $this->purchase_order->edit($slug);
    }
 

    public function show($slug){
        return $this->purchase_order->show($slug);
    }
 

    public function print($slug){
        return $this->purchase_order->print($slug);
    }


    public function update(PurchaseOrderFormRequest $request, $slug){
        return $this->purchase_order->update($request, $slug);
    }

    
    public function destroy($slug){
        return $this->purchase_order->destroy($slug);
    }


    public function buffer(PurchaseOrderFilterRequest $request){  
        return $this->purchase_order->fetchBuffer($request);
    }


    public function toProcess($slug){
        return $this->purchase_order->toProcess($slug);
    }

    
    public function toBuffer($slug){
        return $this->purchase_order->toBuffer($slug);
    }


    
}
