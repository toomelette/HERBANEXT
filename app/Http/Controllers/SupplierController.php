<?php

namespace App\Http\Controllers;


use App\Core\Services\SupplierService;
use App\Http\Requests\Supplier\SupplierFormRequest;
use App\Http\Requests\Supplier\SupplierFilterRequest;


class SupplierController extends Controller{


    protected $supplier;


    public function __construct(SupplierService $supplier){
        $this->supplier = $supplier;
    }

    
    public function index(SupplierFilterRequest $request){
        return $this->supplier->fetch($request);
    }

    
    public function create(){
        return view('dashboard.supplier.create');
    }

   
    public function store(SupplierFormRequest $request){
        return $this->supplier->store($request);
    }
 

    public function edit($slug){
        return $this->supplier->edit($slug);
    }


    public function update(SupplierFormRequest $request, $slug){
        return $this->supplier->update($request, $slug);
    }

    
    public function destroy($slug){
        return $this->supplier->destroy($slug);
    }


}
