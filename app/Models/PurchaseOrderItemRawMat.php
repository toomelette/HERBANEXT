<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItemRawMat extends Model{


    protected $table = 'purchase_order_item_raw_mats';

    protected $dates = ['created_at', 'updated_at'];
    
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'po_no' => '',
    	'po_item_id' => '',
    	'item_raw_mat_id' => '',
        'name' => '',
        'required_quantity' => 0.000,
        'unit_type_id' => '',
        'unit' => '',
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];



    /** RELATIONSHIPS **/
    public function purchaseOrder() {
        return $this->belongsTo('App\Models\PurchaseOrder','po_id','po_id');
    }


    public function purchaseOrderItem() {
    	return $this->belongsTo('App\Models\PurchaseOrderItem','po_item_id','po_item_id');
   	}


    public function itemRawMat() {
    	return $this->belongsTo('App\Models\ItemRawMat','item_raw_mat_id','item_raw_mat_id');
   	}
    

}
