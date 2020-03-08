<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPackMat extends Model{



    protected $table = 'item_pack_mats';
    
	public $timestamps = false;



    protected $attributes = [

        'item_id' => '',
        'product_code' => '',
    	'item_pack_mat_id' => '',
        'item_pack_mat_item_id' => '',
        'name' => '',
        'description' => '',
        'required_quantity' => 0.000,
        'unit_type_id' => '',
        'unit' => '',

    ];



    /** RELATIONSHIPS **/
    public function item() {
        return $this->belongsTo('App\Models\Item','item_id','item_id');
    }
    
    public function itemOrig() {
        return $this->belongsTo('App\Models\Item','item_pack_mat_item_id','item_id');
    }

    public function purchaseOrderItemPackMat() {
        return $this->hasMany('App\Models\PurchaseOrderItemPackMat','item_pack_mat_id','item_pack_mat_id');
    }


    
}
