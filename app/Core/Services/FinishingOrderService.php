<?php
 
namespace App\Core\Services;


use App\Core\Interfaces\FinishingOrderInterface;
use App\Core\Interfaces\FinishingOrderPackMatInterface;
use App\Core\BaseClasses\BaseService;


class FinishingOrderService extends BaseService{


    protected $fo_repo;
    protected $fo_pack_mat_repo;



    public function __construct(FinishingOrderInterface $fo_repo, FinishingOrderPackMatInterface $fo_pack_mat_repo){
        $this->fo_repo = $fo_repo;
        $this->fo_pack_mat_repo = $fo_pack_mat_repo;
        parent::__construct();
    }



    public function fetch($request){
        $finishing_orders = $this->fo_repo->fetch($request);
        $request->flash();
        return view('dashboard.finishing_order.index')->with('finishing_orders', $finishing_orders);
    }



    // public function fillUp($slug){
    //     $manufacturing_order = $this->fo_repo->findbySlug($slug);
    //     return view('dashboard.manufacturing_order.fill_up')->with('manufacturing_order', $manufacturing_order);
    // }



    // public function fillUpPost($request, $slug){

    //     $total_weight = 0;

    //     if (!empty($request->row)) {
    //         foreach ($request->row as $data) {
    //             $mo_raw_mat =  $this->fo_pack_mat_repo->update($data);
    //             if ($mo_raw_mat->req_qty_is_included == true) {
    //                 $total_weight += $mo_raw_mat->req_qty;
    //             }
    //         }
    //     }
        
    //     $this->fo_repo->updateFillUp($request, $slug, $total_weight);
    //     $this->event->fire('manufacturing_order.fill_up_post', $slug);
    //     return redirect()->route('dashboard.manufacturing_order.index');

    // }



    // public function show($slug){
    //     $manufacturing_order = $this->fo_repo->findBySlug($slug);
    //     return view('dashboard.manufacturing_order.show')->with('manufacturing_order', $manufacturing_order);
    // }



    // public function print($slug){
    //     $manufacturing_order = $this->fo_repo->findBySlug($slug);
    //     return view('printables.manufacturing_order.mo')->with('manufacturing_order', $manufacturing_order);
    // }







}