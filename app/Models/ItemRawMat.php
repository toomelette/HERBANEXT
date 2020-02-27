<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemRawMat extends Model{



    protected $table = 'item_raw_mats';
    
	public $timestamps = false;



    protected $attributes = [

        'product_code' => '',
    	'item_raw_mat_id' => '',
        'item_raw_mat_product_code' => '',
        'name' => '',
        'required_quantity' => 0.000,
        'unit_type_id' => '',
        'unit' => '',

    ];



    /** RELATIONSHIPS **/
    public function item() {
        return $this->belongsTo('App\Models\Item','product_code','product_code');
    }



    
}
