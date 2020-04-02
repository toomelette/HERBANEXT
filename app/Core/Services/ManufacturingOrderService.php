<?php
 
namespace App\Core\Services;


use App\Core\Interfaces\ManufacturingOrderInterface;
use App\Core\BaseClasses\BaseService;


class ManufacturingOrderService extends BaseService{


    protected $mo_repo;



    public function __construct(ManufacturingOrderInterface $mo_repo){

        $this->mo_repo = $mo_repo;
        parent::__construct();

    }



    public function fetch($request){

        $manufacturing_orders = $this->mo_repo->fetch($request);
        $request->flash();
        return view('dashboard.manufacturing_order.index')->with('manufacturing_orders', $manufacturing_orders);

    }



    public function fillUp($slug){

        $manufacturing_order = $this->mo_repo->findbySlug($slug);
        return view('dashboard.manufacturing_order.fill_up')->with('manufacturing_order', $manufacturing_order);

    }






}