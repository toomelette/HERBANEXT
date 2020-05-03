<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryItem extends Model{



    protected $table = 'delivery_items';    
	public $timestamps = false;
 


    protected $attributes = [

        'delivery_id' => '',
        'po_item_id' => '',
    ];



    /** RELATIONSHIPS **/
    public function purchaseOrderItem() {
        return $this->belongsTo('App\Models\PurchaseOrderItem','po_item_id','po_item_id');
    }

    public function delivery() {
    	return $this->belongsTo('App\Models\Delivery','delivery_id','delivery_id');
   	}



}
