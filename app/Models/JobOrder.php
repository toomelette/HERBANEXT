<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class JobOrder extends Model{


    use Sortable;

    protected $table = 'job_orders';
    
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'item_id' => '',
        'jo_id' => '',
        'jo_no' => '',
        'po_item_id' => '',
        'po_id' => '',
        'po_no' => '',
        'lot_no' => '',
        'item_name' => '',
        'item_product_code' => '',
        'item_type_id' => '',
        'date' => null,
        'batch_size' => '',
        'pack_size' => '',
        'theo_yield' => '',
        'amount' => 0.00,
        'unit' => '',
        'delivery_status' => '0',
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
    public function item() {
        return $this->belongsTo('App\Models\Item','item_id','item_id');
    }

    public function itemType() {
        return $this->belongsTo('App\Models\ItemType','item_type_id','item_type_id');
    }

    public function purchaseOrder() {
        return $this->belongsTo('App\Models\purchaseOrder','po_id','po_id');
    }


    public function purchaseOrderItem() {
        return $this->belongsTo('App\Models\PurchaseOrderItem','po_item_id','po_item_id');
    }


    public function manufacturingOrder() {
        return $this->hasOne('App\Models\ManufacturingOrder','jo_id','jo_id');
    }


    public function manufacturingOrderRawMat() {
        return $this->hasMany('App\Models\ManufacturingOrderRawMat','jo_id','jo_id');
    }


    public function finishingOrder() {
        return $this->hasOne('App\Models\FinishingOrder','jo_id','jo_id');
    }


    public function finishingOrderPackMat() {
        return $this->hasMany('App\Models\FinishingOrderPackMat','jo_id','jo_id');
    }


    public function deliveryJobOrder() {
        return $this->hasOne('App\Models\DeliveryJobOrder','jo_id','jo_id');
    }




    
}
