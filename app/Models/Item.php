<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Item extends Model{


    use Sortable;

    protected $table = 'items';

    public $sortable = ['product_code', 'name', 'current_balance', 'price', 'min_req_qty'];

    protected $dates = ['created_at', 'updated_at'];
    
	public $timestamps = false;




    protected $attributes = [

        'slug' => '',
        'product_code' => '',
        'item_category_id' => '',
        'unit_type_id' => '',
        'name' => '',
        'description' => '',
        'beginning_balance' => 0.000,
        'current_balance' => 0.000,
        'unit' => '',
        'price' => 0.00,
        'min_req_qty' => 0.000,
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


    public function itemLog() {
        return $this->hasMany('App\Models\ItemLog','product_code','product_code');
    }



    public function itemCategory() {
        return $this->belongsTo('App\Models\ItemCategory','item_category_id','item_category_id');
    }




    
}
