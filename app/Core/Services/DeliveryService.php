<?php
 
namespace App\Core\Services;


use App\Core\Interfaces\DeliveryInterface;
use App\Core\Interfaces\DeliveryJobOrderInterface;
use App\Core\Interfaces\JobOrderInterface;
use App\Core\BaseClasses\BaseService;


class DeliveryService extends BaseService{



    protected $delivery_repo;
    protected $delivery_jo_repo;
    protected $jo_repo;



    public function __construct(DeliveryInterface $delivery_repo, DeliveryJobOrderInterface $delivery_jo_repo, JobOrderInterface $jo_repo){

        $this->delivery_repo = $delivery_repo;
        $this->delivery_jo_repo = $delivery_jo_repo;
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

        if(!empty($request->job_orders)){
            foreach ($request->job_orders as $data) {
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



    public function update($request, $slug){

        $delivery = $this->delivery_repo->findbySlug($slug);

        if (!empty($delivery->deliveryJobOrder)) {
            foreach ($delivery->deliveryJobOrder as $data_djo) {
                $this->jo_repo->updateDeliveryStatus($data_djo->jo_id, 1);
                $this->event->fire('delivery.flush_jo', $data_djo->jo_id);
            }  
        }

        $this->delivery_repo->update($request, $delivery);

        if(!empty($request->job_orders)){
            foreach ($request->job_orders as $data) {
                $this->delivery_jo_repo->store($delivery->delivery_id, $data);
                $this->jo_repo->updateDeliveryStatus($data, 2);
                $this->event->fire('delivery.flush_jo', $data);
            }
        }
        
        $this->event->fire('delivery.update', $delivery);
        return redirect()->route('dashboard.delivery.index');

    }



    public function destroy($slug){

        $delivery = $this->delivery_repo->findbySlug($slug);

        if (!empty($delivery->deliveryJobOrder)) {
            foreach ($delivery->deliveryJobOrder as $data_djo) {
                $this->jo_repo->updateDeliveryStatus($data_djo->jo_id, 1);
                $this->event->fire('delivery.flush_jo', $data_djo->jo_id);
            }  
        }

        $this->delivery_repo->destroy($delivery);

        $this->event->fire('delivery.destroy', $delivery);
        return redirect()->back();

    }



}