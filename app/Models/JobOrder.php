<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobOrder extends Model{



    protected $table = 'job_orders';
    
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'jo_id' => '',
        'jo_no' => '',
        'po_item_id' => '',
        'po_id' => '',
        'po_no' => '',
        'lot_no' => '',
        'item_name' => '',
        'date' => null,
        'batch_size' => 0.00,
        'batch_size_unit' => '',
        'pack_size' => 0.00,
        'pack_size_unit' => '',
        'pack_size_pkging' => '',
        'amount' => 0.00,
        'unit' => '',
        'theo_yield' => 0.00,
        'theo_yield_pkging' => '',
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',


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
