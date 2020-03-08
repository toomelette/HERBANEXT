<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemRawMat extends Model{



    protected $table = 'item_raw_mats';
    
	public $timestamps = false;



    protected $attributes = [

        'item_id' => '',
        'product_code' => '',
    	'item_raw_mat_id' => '',
        'item_raw_mat_item_id' => '',
        'name' => '',
        'required_quantity' => 0.000,
        'unit_type_id' => '',
        'unit' => '',

    ];



    /** RELATIONSHIPS **/
    public function item() {
        return $this->belongsTo('App\Models\Item','item_id','item_id');
    }
    
    public function itemOrig() {
        return $this->belongsTo('App\Models\Item','item_raw_mat_item_id','item_id');
    }

    public function purchaseOrderItemRawMat() {
        return $this->hasMany('App\Models\PurchaseOrderItemRawMat','item_raw_mat_id','item_raw_mat_id');
    }




    
}
