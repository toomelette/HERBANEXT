<?php
 
namespace App\Core\Services;

use App\Core\Interfaces\JobOrderInterface;
use App\Core\Interfaces\PurchaseOrderItemInterface;
use App\Core\BaseClasses\BaseService;


class JobOrderService extends BaseService{


    protected $po_item_repo;
    protected $job_order_repo;


    public function __construct(PurchaseOrderItemInterface $po_item_repo, JobOrderInterface $job_order_repo){

        $this->po_item_repo = $po_item_repo;
        $this->job_order_repo = $job_order_repo;
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

        $batch_size = $po_item->amount / $request->no_of_batch;

        for ($i=0; $i < $request->no_of_batch; $i++) { 
            $this->job_order_repo->store($request, $po_item, $batch_size);
        }

        $this->event->fire('job_order.generate', $slug);
        return redirect()->route('dashboard.job_order.generate_fill', [$slug]);

    }





    public function generateFill($slug){

        $po_item = $this->po_item_repo->findbySlug($slug);
        return view('dashboard.job_order.generate_fill')->with('po_item', $po_item);

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