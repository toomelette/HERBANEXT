<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class PurchaseOrderItem extends Model{


    use Sortable;

    protected $table = 'purchase_order_items';

    public $sortable = ['po_no', 'item.name' ,'amount', 'unit', 'is_generated', 'updated_at'];

    protected $dates = ['created_at', 'updated_at'];
    
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'po_id' => '',
        'po_no' => '',
    	'po_item_id' => '',
        'item_id' => '',
        'item_type_id' => '',
        'item_type_percent' => 0,
        'unit_type_id' => '',
        'amount' => 0.000,
        'unit' => '',
        'item_price' => 0.00,
        'line_price' => 0.00,
        'is_generated' => false,
        'delivery_status' => 1,
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];


    // Delivery Status

    //     0 = Not Ready 
    //     1 = Ready for Delivery 
    //     2 = On the way to client 
    //     3 = Returned 
    //     4 = Completed



    public function isJOCompleted(){

        if($this->delivery_status == 0 && $this->is_generated == 0){

            if (!$this->jobOrder->isEmpty()) {

                $count_total = 0;
                $count_rfd = 0;

                foreach($this->jobOrder as $jo) {
                    $count_total = $count_total + 1;
                    if ($jo->delivery_status == 4) {
                        $count_rfd = $count_rfd + 1;     
                    }
                }

                if ($count_total == $count_rfd) {
                    return true;
                }

                return false;
                
            }

            return true;

        }

        return false;

    }



    public function isReadyForDelivery(){

        if($this->delivery_status == 0 && $this->is_generated == 0){

            if (!$this->jobOrder->isEmpty()) {

                $count_total = 0;
                $count_rfd = 0;

                foreach($this->jobOrder as $jo) {
                    $count_total = $count_total + 1;
                    if ($jo->delivery_status >= 1) {
                        $count_rfd = $count_rfd + 1;     
                    }
                }

                if ($count_total == $count_rfd) {
                    return true;
                }

                return false;
                
            }

            return true;

        }

        return false;

    }




    public function isReadyForDeliverySpan(){

        $span = '';

        if($this->isReadyForDelivery() == false){
            $span = '<span class="badge bg-red"><i class="fa fa-fw fa-times"></i></span>';
        }elseif ($this->isReadyForDelivery() == true) {
            $span = '<span class="badge bg-green"><i class="fa fa-fw fa-check"></i></span>';
        }

        return $span;

    }




    public function isOnTheWayToClient(){

        if($this->purchaseOrder->process_status == 3 && $this->delivery_status == 2){
            return true;
        }

        return false;

    }



    public function displayAmount(){

        $txt = '';

        if ($this->unit != 'PCS') {
            $txt = number_format($this->amount, 3) .' '. $this->unit;
        }else{
            $txt = number_format($this->amount) .' '. $this->unit;
        }

        return $txt;

    }



    public function displayDeliveryConfirmStatus(){

        $string = '';

        if ($this->delivery_status == 3) {
            $string = '<span class="badge bg-red">Returned</span>';
        }elseif($this->delivery_status == 4){
            $string = '<span class="badge bg-green">Delivered</span>';
        }else{
            $string = '<span class="badge bg-orange">Pending .. </span>';
        }

        return $string;

    }




    /** RELATIONSHIPS **/
    public function purchaseOrder() {
        return $this->belongsTo('App\Models\PurchaseOrder','po_id','po_id');
    }

    public function item() {
    	return $this->belongsTo('App\Models\Item','item_id','item_id');
   	}

    public function purchaseOrderItemRawMat() {
        return $this->hasMany('App\Models\PurchaseOrderItemRawMat','po_item_id','po_item_id');
    }

    public function purchaseOrderItemPackMat() {
        return $this->hasMany('App\Models\PurchaseOrderItemPackMat','po_item_id','po_item_id');
    }

    public function jobOrder() {
        return $this->hasMany('App\Models\JobOrder','po_item_id','po_item_id');
    }

    

    
}
