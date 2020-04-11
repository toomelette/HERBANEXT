<?php
 
namespace App\Core\Services;


use App\Core\Interfaces\ManufacturingOrderInterface;
use App\Core\Interfaces\ManufacturingOrderRawMatInterface;
use App\Core\Interfaces\FinishingOrderInterface;
use App\Core\BaseClasses\BaseService;


class ManufacturingOrderService extends BaseService{


    protected $mo_repo;
    protected $mo_raw_mat_repo;
    protected $fo_repo;



    public function __construct(ManufacturingOrderInterface $mo_repo, ManufacturingOrderRawMatInterface $mo_raw_mat_repo, FinishingOrderInterface $fo_repo){
        $this->mo_repo = $mo_repo;
        $this->mo_raw_mat_repo = $mo_raw_mat_repo;
        $this->fo_repo = $fo_repo;
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

        $total_weight = 0;

        if (!empty($request->row)) {
            foreach ($request->row as $data) {
                $mo_raw_mat =  $this->mo_raw_mat_repo->update($data);
                if ($mo_raw_mat->req_qty_is_included == true) {
                    $total_weight += $mo_raw_mat->req_qty;
                }
            }
        }
        
        $mo = $this->mo_repo->updateFillUp($request, $slug, $total_weight);
        $fo = $this->fo_repo->updateFillUpFromMO($request, $mo->jo_id);
        $this->event->fire('manufacturing_order.fill_up_post',  [$mo, $fo]);
        return redirect()->route('dashboard.manufacturing_order.index');

    }



    public function show($slug){
        $manufacturing_order = $this->mo_repo->findBySlug($slug);
        return view('dashboard.manufacturing_order.show')->with('manufacturing_order', $manufacturing_order);
    }



    public function print($slug){
        $manufacturing_order = $this->mo_repo->findBySlug($slug);
        return view('printables.manufacturing_order.mo')->with('manufacturing_order', $manufacturing_order);
    }







}