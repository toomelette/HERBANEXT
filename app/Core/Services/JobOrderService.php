<?php
 
namespace App\Core\Services;


use App\Core\Interfaces\PurchaseOrderItemInterface;
use App\Core\BaseClasses\BaseService;


class JobOrderService extends BaseService{


    protected $po_item_repo;


    public function __construct(PurchaseOrderItemInterface $po_item_repo){

        $this->po_item_repo = $po_item_repo;
        parent::__construct();

    }





    public function fetchPurchaseOrderItem($request){

        $po_items = $this->po_item_repo->fetch($request);

        $request->flash();
        return view('dashboard.job_order.create')->with('po_items', $po_items);

    }





    public function generate($slug){

        $po_item = $this->po_item_repo->findbySlug($slug);
        return view('dashboard.job_order.generate')->with('po_item', $po_item);

    }






    // public function store($request){

    //     $job_order = $this->job_order_repo->store($request);

    //     if(!empty($request->row)){
    //         foreach ($request->row as $row) {
    //             $subjob_order = $this->subjob_order_repo->store($row, $job_order);
    //         }
    //     }
        
    //     $this->event->fire('job_order.store');
    //     return redirect()->back();

    // }






    // public function edit($slug){

    //     $job_order = $this->job_order_repo->findbySlug($slug);
    //     return view('dashboard.job_order.edit')->with('job_order', $job_order);

    // }






    // public function update($request, $slug){

    //     $job_order = $this->job_order_repo->update($request, $slug);

    //     if(!empty($request->row)){
    //         foreach ($request->row as $row) {
    //             $subjob_order = $this->subjob_order_repo->store($row, $job_order);
    //         }
    //     }

    //     $this->event->fire('job_order.update', $job_order);
    //     return redirect()->route('dashboard.job_order.index');

    // }






    // public function destroy($slug){

    //     $job_order = $this->job_order_repo->destroy($slug);

    //     $this->event->fire('job_order.destroy', $job_order);
    //     return redirect()->back();

    // }






}