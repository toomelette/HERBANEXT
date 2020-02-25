<?php
 
namespace App\Core\Services;


use App\Core\Interfaces\PurchaseOrderInterface;
use App\Core\Interfaces\PurchaseOrderItemInterface;
use App\Core\BaseClasses\BaseService;


class PurchaseOrderService extends BaseService{


    protected $purchase_order_repo;
    protected $purchase_order_item_repo;



    public function __construct(PurchaseOrderInterface $purchase_order_repo, PurchaseOrderItemInterface $purchase_order_item_repo){

        $this->purchase_order_repo = $purchase_order_repo;
         $this->purchase_order_item_repo = $purchase_order_item_repo;
        parent::__construct();

    }





    // public function fetch($request){

    //     $purchase_orders = $this->purchase_order_repo->fetch($request);

    //     $request->flash();
    //     return view('dashboard.purchase_order.index')->with('purchase_orders', $purchase_orders);

    // }






    public function store($request){

        $purchase_order = $this->purchase_order_repo->store($request);

        foreach ($request->row as $key => $value) {
            
            

        }

        $this->event->fire('purchase_order.store');
        return redirect()->back();

    }






    // public function edit($slug){

    //     $purchase_order = $this->purchase_order_repo->findbySlug($slug);
    //     return view('dashboard.purchase_order.edit')->with('purchase_order', $purchase_order);

    // }






    // public function update($request, $slug){

    //     $purchase_order = $this->purchase_order_repo->update($request, $slug);

    //     if(!empty($request->row)){
    //         foreach ($request->row as $row) {
    //             $subpurchase_order = $this->subpurchase_or_repo->store($row, $purchase_order);
    //         }
    //     }

    //     $this->event->fire('purchase_order.update', $purchase_order);
    //     return redirect()->route('dashboard.purchase_order.index');

    // }






    // public function destroy($slug){

    //     $purchase_order = $this->purchase_order_repo->destroy($slug);

    //     $this->event->fire('purchase_order.destroy', $purchase_order);
    //     return redirect()->back();

    // }






}