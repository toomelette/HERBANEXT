<?php
 
namespace App\Core\Services;


use App\Core\Interfaces\PurchaseOrderInterface;
use App\Core\Interfaces\PurchaseOrderItemInterface;
use App\Core\Interfaces\ItemInterface;
use App\Core\BaseClasses\BaseService;
use Conversion;


class PurchaseOrderService extends BaseService{


    protected $purchase_order_repo;
    protected $purchase_order_item_repo;
    protected $item_repo;



    public function __construct(PurchaseOrderInterface $purchase_order_repo, PurchaseOrderItemInterface $purchase_order_item_repo, ItemInterface $item_repo){

        $this->purchase_order_repo = $purchase_order_repo;
        $this->purchase_order_item_repo = $purchase_order_item_repo;
        $this->item_repo = $item_repo;
        parent::__construct();

    }





    // public function fetch($request){

    //     $purchase_orders = $this->purchase_order_repo->fetch($request);

    //     $request->flash();
    //     return view('dashboard.purchase_order.index')->with('purchase_orders', $purchase_orders);

    // }






    public function store($request){

        $purchase_order = $this->purchase_order_repo->store($request);

        $subtotal_price = 0.00;
        $total_price = 0.00;

        if (!empty($request->row)) {

            foreach ($request->row as $data) {

                $item = $this->item_repo->findByProductCode($data['item']);

                $amount = $this->__dataType->string_to_num($data['amount']);

                if ($item->unit != 'PCS') {
                    $converted_amount = Conversion::convert($amount, $data['unit'])->to($item->unit)->format(10,'.','');
                }else{
                    $converted_amount = $data['amount'];
                }

                $line_price = $item->price * $converted_amount;
                $this->purchase_order_item_repo->store($data, $item, $purchase_order, $line_price);

                $subtotal_price += $line_price;

            }
            
        }

        $vat_rounded_off = $this->__dataType->string_to_num($request->vat) / 100;   

        $vatable = $subtotal_price * $vat_rounded_off;
        $freight_fee = $this->__dataType->string_to_num($request->freight_fee);

        $total_debit = $vatable + $freight_fee;

        $total_price = $subtotal_price - $total_debit;

        $this->purchase_order_repo->updatePrices($purchase_order, $subtotal_price, $total_price);

        $this->event->fire('purchase_order.store', $purchase_order);
        return redirect()->back();

    }






    // public function edit($slug){

    //     $purchase_order = $this->purchase_order_repo->findbySlug($slug);
    //     return view('dashboard.purchase_order.edit')->with('purchase_order', $purchase_order);

    // }






    public function show($slug){

        $purchase_order = $this->purchase_order_repo->findbySlug($slug);
        return view('dashboard.purchase_order.show')->with('purchase_order', $purchase_order);

    }






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