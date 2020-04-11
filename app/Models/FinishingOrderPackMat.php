<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinishingOrderPackMat extends Model{



    protected $table = 'finishing_order_pack_mats';    
	public $timestamps = false;
 


    protected $attributes = [

        'fo_pack_mat_id' => '',
        'jo_id' => '',
        'fo_id' => '',
        'item_product_code' => '',
        'item_name' => '',
        'item_description' => '',
        'req_qty' => 0.000,
        'req_qty_unit' => '',
        'unit_type_id' => '',
        'qty_issued' => 0.000,
        'qty_issued_unit' => '',
        'figure_actual_usage' => 0.000,
        'figure_regected' => 0.000,
        'figure_damaged' => 0.000,
        'figure_returns' => 0.000,
        'figure_samples' => 0.000,
        'figure_total' => 0.000,
        'figure_difference' => 0.000,
        'figure_unit' => '',

    ];



    /** RELATIONSHIPS **/
    public function jobOrder() {
        return $this->belongsTo('App\Models\JobOrder','jo_id','jo_id');
    }

    public function finishingOrder() {
    	return $this->belongsTo('App\Models\FinishingOrder','fo_id','fo_id');
   	}



}
