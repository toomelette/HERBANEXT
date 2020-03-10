<?php

namespace App\Http\Controllers;

use App\Core\Services\JobOrderService;
use App\Http\Requests\JobOrder\JobOrderFormRequest;
use App\Http\Requests\JobOrder\PurchaseOrderFilterRequest;


class JobOrderController extends Controller{


	protected $job_order;



    public function __construct(JobOrderService $job_order){

        $this->job_order = $job_order;

    }


    
 //    public function index(JobOrderFilterRequest $request){
        
 //        return $this->job_order->fetch($request);

 //    }

    

    public function create(PurchaseOrderFilterRequest $request){
        
        return $this->job_order->fetchPurchaseOrderItem($request);

    }
 



    public function generate($slug){
        
        return $this->job_order->generate($slug);

    }

   

    // public function store(JobOrderFormRequest $request){
        
    //     return $this->job_order->store($request);

    // }
 



    // public function edit($slug){
        
    //     return $this->job_order->edit($slug);

    // }




    // public function update(JobOrderFormRequest $request, $slug){
        
    //     return $this->job_order->update($request, $slug);

    // }

    


    // public function destroy($slug){
        
    //     return $this->job_order->destroy($slug);

    // }


    


}
