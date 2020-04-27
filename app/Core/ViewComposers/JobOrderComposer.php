<?php

namespace App\Core\ViewComposers;


use View;
use App\Core\Interfaces\JobOrderInterface;


class JobOrderComposer{
   



	protected $job_order_repo;




	public function __construct(JobOrderInterface $job_order_repo){

		$this->job_order_repo = $job_order_repo;

	}





    public function compose($view){

        $job_orders = $this->job_order_repo->getAll();
        
    	$view->with('global_job_orders_all', $job_orders);

    }






}