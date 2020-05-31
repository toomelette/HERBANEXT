<?php
 
namespace App\Core\Services;


use App\Core\Interfaces\DeliveryInterface;
use App\Core\Interfaces\DeliveryItemInterface;
use App\Core\Interfaces\DeliveryJOInterface;
use App\Core\Interfaces\PurchaseOrderItemInterface;
use App\Core\Interfaces\JobOrderInterface;
use App\Core\BaseClasses\BaseService;


class DeliveryService extends BaseService{



    protected $delivery_repo;
    protected $delivery_item_repo;
    protected $delivery_jo_repo;
    protected $po_item_repo;
    protected $jo_repo;



    public function __construct(DeliveryInterface $delivery_repo, DeliveryItemInterface $delivery_item_repo, DeliveryJOInterface $delivery_jo_repo, PurchaseOrderItemInterface $po_item_repo, JobOrderInterface $jo_repo){

        $this->delivery_repo = $delivery_repo;
        $this->delivery_item_repo = $delivery_item_repo;
        $this->delivery_jo_repo = $delivery_jo_repo;
        $this->po_item_repo = $po_item_repo;
        $this->jo_repo = $jo_repo;
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

        if(!empty($request->jo)){
            foreach ($request->jo as $data) {
                $this->delivery_jo_repo->store($delivery->delivery_id, $data);
                $this->jo_repo->updateDeliveryStatus($data, 2);
                $this->event->fire('delivery.flush_jo', $data);
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



    public function print($slug){

        $delivery = $this->delivery_repo->findbySlug($slug);
        return view('printables.delivery.delivery_report')->with('delivery', $delivery);

    }



    public function update($request, $slug){

        $delivery = $this->delivery_repo->findbySlug($slug);
        if (!empty($delivery->deliveryItem)) {
            foreach ($delivery->deliveryItem as $data) {
                $this->po_item_repo->updateDeliveryStatus($data->po_item_id, 0);
                $this->event->fire('delivery.flush_po_item', $data->po_item_id);
            }  
        }
        
        if(!empty($delivery->deliveryJO)){
            foreach ($delivery->deliveryJO as $data) {
                $this->jo_repo->updateDeliveryStatus($data->jo_id, 1);
                $this->event->fire('delivery.flush_jo', $data->jo_id);
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

        if(!empty($request->jo)){
            foreach ($request->jo as $data) {
                $this->delivery_jo_repo->store($delivery->delivery_id, $data);
                $this->jo_repo->updateDeliveryStatus($data, 2);
                $this->event->fire('delivery.flush_jo', $data);
            }
        }
        
        $this->event->fire('delivery.update', $delivery);
        return redirect()->route('dashboard.delivery.index');

    }



    public function confirmDelivery($slug){

        $delivery = $this->delivery_repo->findbySlug($slug);
        return view('dashboard.delivery.confirm_delivery')->with('delivery', $delivery);

    }



    public function confirmDeliveredPost($type, $id){

        if (isset($type)) {
                
            if ($type == 'POI') {
                $po_item =  $this->po_item_repo->updateDeliveryStatus($id, 4);
                $this->event->fire('delivery.confirm_delivered_po_item', $po_item);
            }elseif($type == 'JO'){
                $jo = $this->jo_repo->updateDeliveryStatus($id, 4);
                $this->event->fire('delivery.confirm_delivered_jo', $jo);
            }

        }

        return redirect()->back();
    
    }



    public function confirmReturnedPost($type, $id){

        if (isset($type)) {

            if ($type == 'POI') {
                $po_item = $this->po_item_repo->updateDeliveryStatus($id, 3);
                $this->event->fire('delivery.confirm_returned_po_item', $po_item); 
            }elseif($type == 'JO'){
                $jo = $this->jo_repo->updateDeliveryStatus($id, 3);
                $this->event->fire('delivery.confirm_delivered_jo', $jo);
            }

        }

        return redirect()->back();

    }



    public function destroy($slug){

        $delivery = $this->delivery_repo->findbySlug($slug);

        if (!empty($delivery->deliveryItem)) {
            foreach ($delivery->deliveryItem as $data) {
                if (isset($data->PurchaseOrderItem)) {
                    $this->po_item_repo->updateDeliveryStatus($data->po_item_id, 0);
                    $this->event->fire('delivery.flush_po_item', $data->po_item_id);
                }
            }  
        }

        if(!empty($delivery->deliveryJO)){
            foreach ($delivery->deliveryJO as $data) {
                if (isset($data->jobOrder)) {
                    $this->jo_repo->updateDeliveryStatus($data->jo_id, 1);
                    $this->event->fire('delivery.flush_jo', $data->jo_id);
                }
            }
        }

        $this->delivery_repo->destroy($delivery);

        $this->event->fire('delivery.destroy', $delivery);
        return redirect()->back();

    }



}