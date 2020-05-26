<?php

namespace App\Http\Controllers;


use App\Core\Services\DeliveryService;
use App\Http\Requests\Delivery\DeliveryFormRequest;
use App\Http\Requests\Delivery\DeliveryFilterRequest;


class DeliveryController extends Controller{


    protected $delivery;


    public function __construct(DeliveryService $delivery){
        $this->delivery = $delivery;
    }

    
    public function index(DeliveryFilterRequest $request){
        return $this->delivery->fetch($request);
    }

    
    public function create(){
        return view('dashboard.delivery.create');
    }

   
    public function store(DeliveryFormRequest $request){
        return $this->delivery->store($request);
    }
 

    public function edit($slug){
        return $this->delivery->edit($slug);
    }
 
 
    public function update(DeliveryFormRequest $request, $slug){
        return $this->delivery->update($request, $slug);
    }

    
    public function confirmDelivery($slug){
        return $this->delivery->confirmDelivery($slug);
    }

    
    public function confirmDeliveredPost($type, $id){
        return $this->delivery->confirmDeliveredPost($type, $id);
    }

    
    public function confirmReturnedPost($type, $id){
        return $this->delivery->confirmReturnedPost($type, $id);
    }


    public function show($slug){
        return $this->delivery->show($slug);
    }


    public function print($slug){
        return $this->delivery->print($slug);
    }

    
    public function destroy($slug){
        return $this->delivery->destroy($slug);
    }

    
}
