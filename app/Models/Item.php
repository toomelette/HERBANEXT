<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Item extends Model{


    use Sortable;

    protected $table = 'items';

    protected $dates = ['created_at', 'updated_at'];
    
	public $timestamps = false;




    protected $attributes = [

        'product_code' => '',
        'item_type_id' => '',
        'slug' => '',
        'name' => '',
        'description' => '',
        'quantity' => 0.00,
        'weight' => 0.00,
        'weight_unit' => '',
        'price' => 0.00,
        'min_req_qty' => 0.00,
        'is_incoming' => false,
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];





    /** RELATIONSHIPS **/
    public function itemBatch() {
    	return $this->hasMany('App\Models\ItemBatch','product_code','product_code');
   	}




    
}
