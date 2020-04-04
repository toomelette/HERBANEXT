<?php
 
namespace App\Core\Services;


use App\Core\Interfaces\ManufacturingOrderInterface;
use App\Core\Interfaces\ManufacturingOrderRawMatInterface;
use App\Core\BaseClasses\BaseService;


class ManufacturingOrderService extends BaseService{


    protected $mo_repo;
    protected $mo_raw_mat_repo;



    public function __construct(ManufacturingOrderInterface $mo_repo, ManufacturingOrderRawMatInterface $mo_raw_mat_repo){

        $this->mo_repo = $mo_repo;
        $this->mo_raw_mat_repo = $mo_raw_mat_repo;
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



    public function fillUpPost($request, $slug){

        $total = 0;

        if (!empty($request->row)) {
            foreach ($request->row as $data) {
                
                $mo_raw_mat =  $this->mo_raw_mat_repo->update($data);

            }
        }

        $this->mo_repo->updateFillUp($request, $slug, $total);

        $this->event->fire('manufacturing_order.fill_up_post', $slug);
        return redirect()->route('dashboard.manufacturing_order.index');

    }






}