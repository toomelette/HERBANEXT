<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class ItemBatch extends Model{


    use Sortable;

    protected $table = 'item_batches';

    protected $dates = ['expiry_date', 'created_at', 'updated_at'];
    
	public $timestamps = false;



    protected $attributes = [

        'batch_code' => '',
        'slug' => '',
        'product_code' => '',
        'quantity' => 0.000,
        'weight' => 0.000,
        'weight_unit' => '',
        'expiry_date' => null,

        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];

    
}
