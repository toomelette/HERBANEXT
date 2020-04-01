<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManufacturingOrderRawMat extends Model{



    protected $table = 'manufacturing_order_raw_mat';    
	public $timestamps = false;
 


    protected $attributes = [

        'mo_raw_mat_id' => '',
        'jo_id' => '',
        'mo_id' => '',
        'item_product_code' => '',
        'item_name' => '',
        'req_qty' => 0.000,
        'req_qty_unit' => '',
        'batch_no' => '',
        'weighed_by' => '',

    ];



    /** RELATIONSHIPS **/
    public function jobOrder() {
        return $this->belongsTo('App\Models\JobOrder','jo_id','jo_id');
    }

    public function manufacturingOrder() {
    	return $this->belongsTo('App\Models\ManufacturingOrder','mo_id','mo_id');
   	}



}
