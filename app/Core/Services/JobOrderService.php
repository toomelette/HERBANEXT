<?php
 
namespace App\Core\Services;

use App\Core\Interfaces\PurchaseOrderItemInterface;
use App\Core\Interfaces\JobOrderInterface;
use App\Core\Interfaces\ManufacturingOrderInterface;
use App\Core\Interfaces\ManufacturingOrderRawMatInterface;
use App\Core\BaseClasses\BaseService;


class JobOrderService extends BaseService{


    protected $po_item_repo;
    protected $job_order_repo;
    protected $manufacturing_order_repo;
    protected $mo_raw_mat_repo;


    public function __construct(PurchaseOrderItemInterface $po_item_repo, JobOrderInterface $job_order_repo, ManufacturingOrderInterface $manufacturing_order_repo, ManufacturingOrderRawMatInterface $mo_raw_mat_repo){

        $this->po_item_repo = $po_item_repo;
        $this->job_order_repo = $job_order_repo;
        $this->manufacturing_order_repo = $manufacturing_order_repo;
        $this->mo_raw_mat_repo = $mo_raw_mat_repo;
        parent::__construct();

    }





    public function fetchPurchaseOrderItem($request){

        $po_items = $this->po_item_repo->fetch($request);

        $request->flash();
        return view('dashboard.job_order.create')->with('po_items', $po_items);

    }




    public function generate($request, $slug){

        $po_item = $this->po_item_repo->findbySlug($slug);
        $this->po_item_repo->generate($po_item);

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
                $manufacturing_order = $this->manufacturing_order_repo->store($job_order);

                foreach ($job_order->item->itemRawMat as $data_item_raw_mat) {
                    $this->mo_raw_mat_repo->store($manufacturing_order, $data_item_raw_mat);
                }

            }
        }

        $this->event->fire('job_order.generate_fill_post', $slug);
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






}