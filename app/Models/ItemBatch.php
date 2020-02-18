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

        'product_code' => '',
    	'batch_code' => '',
        'amount' => 0.000,
        'unit' => '',
        'expiry_date' => null,
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];





    /** RELATIONSHIPS **/
    public function item() {
    	return $this->belongsTo('App\Models\Item','product_code','product_code');
   	}


    public function itemLog() {
        return $this->hasOne('App\Models\ItemLog','batch_code','batch_code');
    }






    
}
