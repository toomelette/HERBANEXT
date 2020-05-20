<?php

namespace App\Core\ViewComposers;


use View;
use App\Core\Interfaces\SupplierInterface;


class SupplierComposer{
   

	protected $supplier_repo;


	public function __construct(SupplierInterface $supplier_repo){
		$this->supplier_repo = $supplier_repo;
	}


    public function compose($view){
        $suppliers = $this->supplier_repo->getAll();
    	$view->with('global_suppliers_all', $suppliers);
    }


}