<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model{



    protected $table = 'purchase_order_items';

    protected $dates = ['expiry_date', 'created_at', 'updated_at'];
    
	public $timestamps = false;



    protected $attributes = [

        'po_no' => '',
    	'po_item_id' => '',
        'product_code' => '',
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



    
}
