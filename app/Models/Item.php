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
        'slug' => '',
        'name' => '',
        'description' => '',
        'type' => '',
        'quantity' => 0.000,
        'weight' => 0.000,
        'weight_unit' => '',
        'price' => 0.000,
        'min_req_qty' => 0.000,
        'is_incoming' => 0,

        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];



}
