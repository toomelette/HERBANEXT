<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPackMat extends Model{



    protected $table = 'item_pack_mats';
    
	public $timestamps = false;



    protected $attributes = [

        'product_code' => '',
    	'item_pack_mat_id' => '',
        'item_pack_mat_product_code' => '',
        'name' => '',
        'description' => '',
        'required_quantity' => 0.000,
        'unit_type_id' => '',
        'unit' => '',

    ];



    /** RELATIONSHIPS **/
    public function item() {
        return $this->belongsTo('App\Models\Item','product_code','product_code');
    }

    public function purchaseOrderItemPackMat() {
        return $this->hasMany('App\Models\PurchaseOrderItemPackMat','item_pack_mat_id','item_pack_mat_id');
    }


    
}
