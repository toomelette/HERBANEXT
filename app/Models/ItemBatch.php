<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemBatch extends Model{



    protected $table = 'item_batches';

    protected $dates = ['expiry_date', 'created_at', 'updated_at'];
    
	public $timestamps = false;



    protected $attributes = [

    	'batch_code' => '',
        'product_code' => '',
        'slug' => '',
        'quantity' => 0.00,
        'weight' => 0.00,
        'weight_unit' => '',
        'expiry_date' => null,
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];





    /** RELATIONSHIPS **/
    public function itemBatch() {
    	return $this->belongsTo('App\Models\Item','product_code','product_code');
   	}






    
}
