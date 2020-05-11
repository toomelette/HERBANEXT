<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class PurchaseOrder extends Model{



    use Sortable;

    protected $table = 'purchase_orders';

    public $sortable = ['po_no', 'bill_to_name', 'ship_to_name', 'total_price'];

    protected $dates = ['created_at', 'updated_at'];
    
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'po_id' => '',
        'po_no' => '',
        'bill_to_name' => '',
        'bill_to_company' => '',
        'bill_to_address' => '',
        'ship_to_name' => '',
        'ship_to_company' => '',
        'ship_to_address' => '',
        'type' => 0,
        'process_status' => 0,
        'freight_fee' => 0.00,
        'vat' => 0.00,
        'instructions' => '',
        'subtotal_price' => 0.00,
        'total_price' => 0.00,
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];



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

        if (!$this->purchaseOrderItem->isEmpty()) {

            $count_total = 0;
            $count_completed = 0;

            foreach($this->purchaseOrderItem as $po_item) {
                $count_total = $count_total + 1;
                if ($po_item->delivery_status == 4) {
                    $count_completed = $count_completed + 1;     
                }
            }

            if ($count_total == $count_completed) {
                return true;
            }

            return false;
            
        }

        return false;

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
