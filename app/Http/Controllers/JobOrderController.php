<?php

namespace App\Http\Controllers;

use App\Core\Services\JobOrderService;
use App\Http\Requests\JobOrder\JobOrderGenerateFormRequest;
use App\Http\Requests\JobOrder\JobOrderGenerateFillFormRequest;
use App\Http\Requests\JobOrder\JobOrderFilterRequest;
use App\Http\Requests\JobOrder\PurchaseOrderItemFilterRequest;


class JobOrderController extends Controller{



	protected $job_order;



    public function __construct(JobOrderService $job_order){

        $this->job_order = $job_order;

    }


    
    public function index(JobOrderFilterRequest $request){
        
        return $this->job_order->fetch($request);

    }

    

    public function create(PurchaseOrderItemFilterRequest $request){
        
        return $this->job_order->fetchPurchaseOrderItem($request);

    }
 



    public function generate(JobOrderGenerateFormRequest $request, $slug){
        
        return $this->job_order->generate($request, $slug);

    }
 



    public function generateFill($slug){
        
        return $this->job_order->generateFill($slug);

    }
 



    public function generateFillPost(JobOrderGenerateFillFormRequest $request, $slug){
        
        return $this->job_order->generateFillPost($request, $slug);

    }

   

    public function show($slug){
        
        return $this->job_order->show($slug);

    }

   

    public function print($slug){
        
        return $this->job_order->print($slug);

    }

   

    public function confirmRFD($status, $slug){
        
        return $this->job_order->confirmRFD($status, $slug);

    }


    


}
