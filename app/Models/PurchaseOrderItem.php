<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model{



    protected $table = 'purchase_order_items';

    protected $dates = ['expiry_date', 'created_at', 'updated_at'];
    
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'po_no' => '',
    	'po_item_id' => '',
        'product_code' => '',
        'unit_type_id' => '',
        'amount' => 0.000,
        'unit' => '',
        'item_price' => 0.00,
        'line_price' => 0.00,

    ];




    /** RELATIONSHIPS **/
    public function purchaseOrder() {
        return $this->belongsTo('App\Models\PurchaseOrder','po_no','po_no');
    }

    public function item() {
    	return $this->belongsTo('App\Models\Item','product_code','product_code');
   	}

    public function purchaseOrderItemRawMat() {
        return $this->hasMany('App\Models\PurchaseOrderItemRawMat','po_item_id','po_item_id');
    }

    public function purchaseOrderItemPackMat() {
        return $this->hasMany('App\Models\PurchaseOrderItemPackMat','po_item_id','po_item_id');
    }



    
}
