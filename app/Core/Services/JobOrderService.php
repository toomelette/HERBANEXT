<?php
 
namespace App\Core\Services;

use App\Core\Interfaces\PurchaseOrderInterface;
use App\Core\Interfaces\PurchaseOrderItemInterface;
use App\Core\Interfaces\JobOrderInterface;
use App\Core\Interfaces\ManufacturingOrderInterface;
use App\Core\Interfaces\ManufacturingOrderRawMatInterface;
use App\Core\Interfaces\FinishingOrderInterface;
use App\Core\Interfaces\FinishingOrderPackMatInterface;
use App\Core\BaseClasses\BaseService;


class JobOrderService extends BaseService{


    protected $po_repo;
    protected $po_item_repo;
    protected $job_order_repo;
    protected $manufacturing_order_repo;
    protected $mo_raw_mat_repo;
    protected $finishing_order_repo;
    protected $fo_pack_mat_repo;


    public function __construct(PurchaseOrderInterface $po_repo, PurchaseOrderItemInterface $po_item_repo, JobOrderInterface $job_order_repo, ManufacturingOrderInterface $manufacturing_order_repo, ManufacturingOrderRawMatInterface $mo_raw_mat_repo, FinishingOrderInterface $finishing_order_repo, FinishingOrderPackMatInterface $fo_pack_mat_repo){

        $this->po_repo = $po_repo;
        $this->po_item_repo = $po_item_repo;
        $this->job_order_repo = $job_order_repo;
        $this->manufacturing_order_repo = $manufacturing_order_repo;
        $this->mo_raw_mat_repo = $mo_raw_mat_repo;
        $this->finishing_order_repo = $finishing_order_repo;
        $this->fo_pack_mat_repo = $fo_pack_mat_repo;
        parent::__construct();

    }





    public function fetch($request){

        $job_orders = $this->job_order_repo->fetch($request);
        $request->flash();
        return view('dashboard.job_order.index')->with('job_orders', $job_orders);

    }





    public function fetchPurchaseOrderItem($request){

        $po_items = $this->po_item_repo->fetch($request);
        $request->flash();
        return view('dashboard.job_order.create')->with('po_items', $po_items);

    }




    public function generate($request, $slug){

        $po_item = $this->po_item_repo->findbySlug($slug);

        $this->po_repo->updateProcessStatus($po_item->purchaseOrder->slug, 2);

        $this->po_item_repo->updateIsGenerated($po_item->slug, 1);

        for ($i=0; $i < $request->no_of_batch; $i++) { 
            $this->job_order_repo->store($po_item);
        }

        $this->event->fire('job_order.generate', $slug);
        return redirect()->route('dashboard.job_order.generate_fill', [$slug]);

    }




    public function generateFill($slug){

        $po_item = $this->po_item_repo->findbySlug($slug);
        return view('dashboard.job_order.generate_fill')->with('po_item', $po_item);

    }




    public function generateFillPost($request, $slug){

        if (!empty($request->row)) {
            foreach ($request->row as $data) {

                $job_order = $this->job_order_repo->updateGenerateFillPost($data);

                $this->event->fire('job_order.generate_fill_post', [$slug, $job_order->jo_id]);

            }
        }
        
        return redirect()->route('dashboard.job_order.create');

    }






    public function show($slug){

        $po_item = $this->po_item_repo->findbySlug($slug);
        return view('dashboard.job_order.show')->with('po_item', $po_item);

    }







    public function print($slug){

        $po_item = $this->po_item_repo->findbySlug($slug);
        return view('printables.job_order.jo')->with('po_item', $po_item);

    }




    public function confirmRFD($status, $slug){

        $job_order = $this->job_order_repo->findbySlug($slug);

        if ($status == 'check') {
            $this->job_order_repo->updateDeliveryStatus($job_order->jo_id, 1);
            $this->po_repo->updateProcessStatus($job_order->purchaseOrder->slug, 3);
        }elseif ($status == 'uncheck') {
            $this->job_order_repo->updateDeliveryStatus($job_order->jo_id, 0);
        }

        $this->event->fire('job_order.confirm_rfd', $job_order);
        return redirect()->back();

    }






}