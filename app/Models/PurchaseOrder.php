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
        'process_status' => 0,
        'buffer_status' => 0,
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



    
}
