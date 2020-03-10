<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class PurchaseOrderItem extends Model{


    use Sortable;

    protected $table = 'purchase_order_items';

    public $sortable = ['po_no', 'amount', 'unit', 'updated_at'];

    protected $dates = ['created_at', 'updated_at'];
    
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'po_id' => '',
        'po_no' => '',
    	'po_item_id' => '',
        'item_id' => '',
        'unit_type_id' => '',
        'amount' => 0.000,
        'unit' => '',
        'item_price' => 0.00,
        'line_price' => 0.00,
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
