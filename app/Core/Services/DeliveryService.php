<?php
 
namespace App\Core\Services;


use App\Core\Interfaces\DeliveryInterface;
use App\Core\Interfaces\DeliveryItemInterface;
use App\Core\Interfaces\PurchaseOrderItemInterface;
use App\Core\BaseClasses\BaseService;


class DeliveryService extends BaseService{



    protected $delivery_repo;
    protected $delivery_item_repo;
    protected $po_item_repo;



    public function __construct(DeliveryInterface $delivery_repo, DeliveryItemInterface $delivery_item_repo, PurchaseOrderItemInterface $po_item_repo){

        $this->delivery_repo = $delivery_repo;
        $this->delivery_item_repo = $delivery_item_repo;
        $this->po_item_repo = $po_item_repo;
        parent::__construct();

    }



    public function fetch($request){

        $deliveries = $this->delivery_repo->fetch($request);
        $request->flash();
        return view('dashboard.delivery.index')->with('deliveries', $deliveries);

    }



    public function store($request){    

        $delivery = $this->delivery_repo->store($request);

        if(!empty($request->po_items)){
            foreach ($request->po_items as $data) {
                $this->delivery_item_repo->store($delivery->delivery_id, $data);
                $this->po_item_repo->updateDeliveryStatus($data, 2);
                $this->event->fire('delivery.flush_po_item', $data);
            }
        }

        $this->event->fire('delivery.store');
        return redirect()->back();

    }



    public function edit($slug){

        $delivery = $this->delivery_repo->findbySlug($slug);
        return view('dashboard.delivery.edit')->with('delivery', $delivery);

    }



    public function show($slug){

        $delivery = $this->delivery_repo->findbySlug($slug);
        return view('dashboard.delivery.show')->with('delivery', $delivery);

    }



    public function update($request, $slug){

        $delivery = $this->delivery_repo->findbySlug($slug);

        if (!empty($delivery->deliveryItem)) {
            foreach ($delivery->deliveryItem as $data) {
                $this->po_item_repo->updateDeliveryStatus($data->po_item_id, 0);
                $this->event->fire('delivery.flush_po_item', $data->po_item_id);
            }  
        }

        $this->delivery_repo->update($request, $delivery);

        if(!empty($request->po_items)){
            foreach ($request->po_items as $data) {
                $this->delivery_item_repo->store($delivery->delivery_id, $data);
                $this->po_item_repo->updateDeliveryStatus($data, 2);
                $this->event->fire('delivery.flush_po_item', $data);
            }
        }
        
        $this->event->fire('delivery.update', $delivery);
        return redirect()->route('dashboard.delivery.index');

    }



    public function confirmDelivery($slug){

        $delivery = $this->delivery_repo->findbySlug($slug);
        return view('dashboard.delivery.confirm_delivery')->with('delivery', $delivery);

    }



    public function confirmDeliveredPost($po_item_id){

        $po_item =  $this->po_item_repo->updateDeliveryStatus($po_item_id, 4);
        $this->event->fire('delivery.confirm_delivered', $po_item);
        return redirect()->back();
    
    }



    public function confirmReturnedPost($po_item_id){

        $po_item = $this->po_item_repo->updateDeliveryStatus($po_item_id, 3);
        $this->event->fire('delivery.confirm_returned', $po_item);
        return redirect()->back();

    }



    public function destroy($slug){

        $delivery = $this->delivery_repo->findbySlug($slug);

        if (!empty($delivery->deliveryItem)) {
            foreach ($delivery->deliveryItem as $data) {
                $this->po_item_repo->updateDeliveryStatus($data->po_item_id, 0);
                $this->event->fire('delivery.flush_po_item', $data->po_item_id);
            }  
        }

        $this->delivery_repo->destroy($delivery);

        $this->event->fire('delivery.destroy', $delivery);
        return redirect()->back();

    }



}