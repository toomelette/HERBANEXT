<?php
 
namespace App\Core\Services;


use App\Core\Interfaces\DeliveryInterface;
use App\Core\Interfaces\DeliveryJobOrderInterface;
use App\Core\BaseClasses\BaseService;


class DeliveryService extends BaseService{



    protected $delivery_repo;
    protected $delivery_jo_repo;



    public function __construct(DeliveryInterface $delivery_repo, DeliveryJobOrderInterface $delivery_jo_repo){

        $this->delivery_repo = $delivery_repo;
        $this->delivery_jo_repo = $delivery_jo_repo;
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

        $delivery = $this->delivery_repo->update($request, $slug);

        if(!empty($request->job_orders)){
            foreach ($request->job_orders as $data) {
                $this->delivery_jo_repo->store($delivery->delivery_id, $data);
            }
        }
        
        $this->event->fire('delivery.update', $delivery);
        return redirect()->route('dashboard.delivery.index');

    }



    public function destroy($slug){

        $delivery = $this->delivery_repo->destroy($slug);
        $this->event->fire('delivery.destroy', $delivery);
        return redirect()->back();

    }



}