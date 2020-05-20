<?php
 
namespace App\Core\Services;


use App\Core\Interfaces\SupplierInterface;
use App\Core\BaseClasses\BaseService;


class SupplierService extends BaseService{



    protected $supplier_repo;



    public function __construct(SupplierInterface $supplier_repo){

        $this->supplier_repo = $supplier_repo;
        parent::__construct();

    }



    public function fetch($request){

        $suppliers = $this->supplier_repo->fetch($request);
        $request->flash();
        return view('dashboard.supplier.index')->with('suppliers', $suppliers);

    }



    public function store($request){

        $supplier = $this->supplier_repo->store($request);
        $this->event->fire('supplier.store');
        return redirect()->back();

    }



    public function edit($slug){

        $supplier = $this->supplier_repo->findbySlug($slug);
        return view('dashboard.supplier.edit')->with('supplier', $supplier);

    }



    public function update($request, $slug){

        $supplier = $this->supplier_repo->update($request, $slug);
        $this->event->fire('supplier.update', $supplier);
        return redirect()->route('dashboard.supplier.index');

    }



    public function destroy($slug){

        $supplier = $this->supplier_repo->destroy($slug);
        $this->event->fire('supplier.destroy', $supplier);
        return redirect()->back();

    }




}