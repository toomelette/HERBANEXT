<?php
 
namespace App\Core\Services;


use App\Core\Interfaces\PurchaseOrderInterface;
use App\Core\Interfaces\JobOrderInterface;
use App\Core\Interfaces\FinishingOrderInterface;
use App\Core\Interfaces\FinishingOrderPackMatInterface;
use App\Core\BaseClasses\BaseService;


class FinishingOrderService extends BaseService{


    protected $po_repo;
    protected $jo_repo;
    protected $fo_repo;
    protected $fo_pack_mat_repo;



    public function __construct(PurchaseOrderInterface $po_repo, JobOrderInterface $jo_repo, FinishingOrderInterface $fo_repo, FinishingOrderPackMatInterface $fo_pack_mat_repo){
        $this->po_repo = $po_repo;
        $this->jo_repo = $jo_repo;
        $this->fo_repo = $fo_repo;
        $this->fo_pack_mat_repo = $fo_pack_mat_repo;
        parent::__construct();
    }



    public function fetch($request){
        $finishing_orders = $this->fo_repo->fetch($request);
        $request->flash();
        return view('dashboard.finishing_order.index')->with('finishing_orders', $finishing_orders);
    }



    public function fillUp($slug){
        $finishing_order = $this->fo_repo->findbySlug($slug);
        return view('dashboard.finishing_order.fill_up')->with('finishing_order', $finishing_order);
    }



    public function fillUpPost($request, $slug){

        if (!empty($request->row)) {
            foreach ($request->row as $data) {
                $this->fo_pack_mat_repo->update($data);
            }
        }

        if (!empty($request->row_figure)) {
            foreach ($request->row_figure as $data_figure) {
                $this->fo_pack_mat_repo->updateFigures($data_figure);
            }
        }
        
        $fo = $this->fo_repo->updateFillUp($request, $slug);
        $jo = $this->jo_repo->updateDeliveryStatus($fo->jo_id, 1);
        $po = $this->po_repo->updateProcessStatus($jo->purchaseOrder->slug, 3);
        $this->event->fire('finishing_order.fill_up_post', $fo);
        return redirect()->route('dashboard.finishing_order.index');

    }



    public function show($slug){
        $finishing_order = $this->fo_repo->findBySlug($slug);
        return view('dashboard.finishing_order.show')->with('finishing_order', $finishing_order);
    }



    public function print($slug){
        $finishing_order = $this->fo_repo->findBySlug($slug);
        return view('printables.finishing_order.fo')->with('finishing_order', $finishing_order);
    }



}