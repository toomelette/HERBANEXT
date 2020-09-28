<?php
 
namespace App\Core\Services;


use App\Core\Interfaces\ItemInterface;
use App\Core\Interfaces\PurchaseOrderInterface;
use App\Core\Interfaces\PurchaseOrderItemInterface;
use App\Core\Interfaces\PurchaseOrderItemRawMatInterface;
use App\Core\Interfaces\PurchaseOrderItemPackMatInterface;
use App\Core\BaseClasses\BaseService;
use Conversion;


class PurchaseOrderService extends BaseService{


    protected $item_repo;
    protected $purchase_order_repo;
    protected $purchase_order_item_repo;
    protected $purchase_order_item_rm_repo;
    protected $purchase_order_item_pm_repo;



    public function __construct(ItemInterface $item_repo, PurchaseOrderInterface $purchase_order_repo, PurchaseOrderItemInterface $purchase_order_item_repo, PurchaseOrderItemRawMatInterface $purchase_order_item_rm_repo, PurchaseOrderItemPackMatInterface $purchase_order_item_pm_repo){
        
        $this->item_repo = $item_repo;
        $this->purchase_order_repo = $purchase_order_repo;
        $this->purchase_order_item_repo = $purchase_order_item_repo;
        $this->purchase_order_item_rm_repo = $purchase_order_item_rm_repo;
        $this->purchase_order_item_pm_repo = $purchase_order_item_pm_repo;
        parent::__construct();

    }



    public function fetch($request){

        $purchase_orders = $this->purchase_order_repo->fetch($request);
        $request->flash();
        return view('dashboard.purchase_order.index')->with('purchase_orders', $purchase_orders);

    }



    public function fetchBuffer($request){

        $purchase_orders = $this->purchase_order_repo->fetchBuffer($request);
        $request->flash();
        return view('dashboard.purchase_order.buffer')->with('purchase_orders', $purchase_orders);

    }



    public function store($request){
        
        $purchase_order = $this->purchase_order_repo->store($request);

        $subtotal_price = 0.0000;
        $total_price = 0.0000;

        if (!empty($request->row)) {

            foreach ($request->row as $data) {

                $item = $this->item_repo->findByItemId($data['item']);

                $amount = $this->__dataType->string_to_num($data['amount']);

                if ($item->unit != 'PCS') {
                    $converted_amount = Conversion::convert($amount, $data['unit'])->to($item->unit)->format(10,'.','');
                }else{
                    $converted_amount = $amount;
                }

                $line_price = $item->price * $converted_amount;
                $po_item = $this->purchase_order_item_repo->store($data, $item, $purchase_order, $line_price);
                $subtotal_price += $line_price;

                foreach ($item->itemRawMat as $data_irm) {
                    $this->purchase_order_item_rm_repo->store($purchase_order, $po_item->po_item_id, $data_irm);
                }

                foreach ($item->itemPackMat as $data_ipm) {
                    $this->purchase_order_item_pm_repo->store($purchase_order, $po_item->po_item_id, $data_ipm);
                }

            }
            
        }

        $vat_rounded_off = $this->__dataType->string_to_num($request->vat) / 100;   
        $vatable = $subtotal_price * $vat_rounded_off;
        $freight_fee = $this->__dataType->string_to_num($request->freight_fee);
        //$total_price = $subtotal_price + $vatable;
        $total_price = $subtotal_price + $freight_fee;

        $this->purchase_order_repo->updatePrices($purchase_order, $subtotal_price, $total_price);

        $this->event->fire('purchase_order.store', $purchase_order);
        return redirect()->back();

    }



    public function edit($slug){

        $purchase_order = $this->purchase_order_repo->findbySlug($slug);
        return view('dashboard.purchase_order.edit')->with('purchase_order', $purchase_order);

    }



    public function show($slug){

        $purchase_order = $this->purchase_order_repo->findbySlug($slug);
        return view('dashboard.purchase_order.show')->with('purchase_order', $purchase_order);

    }



    public function print($slug){

        $purchase_order = $this->purchase_order_repo->findbySlug($slug);
        return view('printables.purchase_order.po')->with('purchase_order', $purchase_order);

    }



    public function update($request, $slug){
        
        $purchase_order = $this->purchase_order_repo->update($request, $slug);
        $route = $purchase_order->buffer_status == 1 ? 'dashboard.purchase_order.buffer' : 'dashboard.purchase_order.index'; 
        $this->event->fire('purchase_order.update', $purchase_order);
        return redirect()->route($route);

    }



    public function destroy($slug){

        $purchase_order = $this->purchase_order_repo->destroy($slug);
        $this->event->fire('purchase_order.destroy', $purchase_order);
        return redirect()->back();

    }



    public function toProcess($slug){

        $purchase_order = $this->purchase_order_repo->updateType($slug, 1);
        $this->event->fire('purchase_order.update_type', $purchase_order);
        return redirect()->back();

    }



    public function toBuffer($slug){

        $purchase_order = $this->purchase_order_repo->updateType($slug, 2);
        $this->event->fire('purchase_order.update_type', $purchase_order);
        return redirect()->back();

    }




}