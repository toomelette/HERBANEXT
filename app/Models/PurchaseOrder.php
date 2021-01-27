<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class PurchaseOrder extends Model{



    use Sortable;

    protected $table = 'purchase_orders';

    protected $dates = ['date_required', 'created_at', 'updated_at'];

    protected $sortable = ['po_no', 'bill_to_name', 'ship_to_name', 'created_at', 'process_status'];
    
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'po_id' => '',
        'po_no' => '',
        'date_required' => null,
        'bill_to_name' => '',
        'bill_to_company' => '',
        'bill_to_address' => '',
        'ship_to_name' => '',
        'ship_to_company' => '',
        'ship_to_address' => '',
        'type' => 0,
        'process_status' => 0,
        'freight_fee' => 0.0000,
        'vat' => 0.0000,
        'instructions' => '',
        'subtotal_price' => 0.0000,
        'total_price' => 0.0000,
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];



    // Type 

    //     1 = For Process
    //     2 = Buffer

    // Process Status

    //     1 = Pending
    //     2 = Manufacturing
    //     3 = Subject For Delivery
    //     4 = Completed



    public function displayProcessStatusSpan(){

        $string = '';

        if ($this->process_status == 1) {
            $string = '<span class="badge bg-yellow">PENDING..</span>';
        }elseif($this->process_status == 2){
            $string = '<span class="badge bg-orange">MANUFACTURING..</span>';
        }elseif($this->process_status == 3){
            if ($this->isDeliveryCompleted() == true) {
                $string = '<span class="badge bg-green">DELIVERED</span>';
            }else{
                $string = '<span class="badge bg-blue">SUBJECT FOR DELIVERY..</span>';
            }
        }

        return $string;

    }



    public function displayProcessStatusText(){

        $string = '';

        if ($this->process_status == 1) {
            $string = 'PENDING';
        }elseif($this->process_status == 2){
            $string = 'MANUFACTURING';
        }elseif($this->process_status == 3){
            if ($this->isDeliveryCompleted() == true) {
                $string = 'DELIVERED';
            }else{
                $string = 'SUBJECT FOR DELIVERY';
            }
        }

        return $string;

    }



    public function isDeliveryCompleted(){

        $bool = false;

        if (!$this->purchaseOrderItem->isEmpty() && $this->jobOrder->isEmpty()) {

            $count_total = 0;
            $count_completed = 0;

            foreach($this->purchaseOrderItem as $po_item) {
                $count_total = $count_total + 1;
                if ($po_item->delivery_status == 4) {
                    $count_completed = $count_completed + 1; 
                }
            }

            if ($count_total == $count_completed) {
                $bool = true;
            }

        }elseif(!$this->jobOrder->isEmpty()){

            $count_total = 0;
            $count_completed = 0;

            foreach($this->jobOrder as $jo) {
                $count_total = $count_total + 1;
                if ($jo->delivery_status == 4) {
                    $count_completed = $count_completed + 1;     
                }
            }

            if ($count_total == $count_completed) {
                $bool = true;
            }

        }

        return $bool;

    }



    /** RELATIONSHIPS **/
    public function purchaseOrderItem() {
    	return $this->hasMany('App\Models\PurchaseOrderItem','po_id','po_id');
   	}

    public function purchaseOrderItemRawMat() {
        return $this->hasMany('App\Models\PurchaseOrderItemRawMat','po_id','po_id');
    }

    public function purchaseOrderItemPackMat() {
        return $this->hasMany('App\Models\PurchaseOrderItemPackMat','po_id','po_id');
    }

    public function jobOrder() {
        return $this->hasMany('App\Models\JobOrder','po_id','po_id');
    }

    public function manufacturingOrder() {
        return $this->hasMany('App\Models\ManufacturingOrder','po_id','po_id');
    }

    public function finishingOrder() {
        return $this->hasMany('App\Models\FinishingOrder','po_id','po_id');
    }

    
    
}
