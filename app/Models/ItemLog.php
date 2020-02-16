<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class ItemLog extends Model{

    use Sortable;

    protected $table = 'item_logs';

    protected $dates = ['created_at', 'updated_at'];

    public $sortable = ['product_code', 'transaction_type', 'amount', 'unit', 'updated_at'];
    
	public $timestamps = false;



    protected $attributes = [

        'product_code' => '',
    	'transaction_type' => false,
        'amount' => 0.000,
        'unit' => '',
        'balance_before_transaction' => 0.000,
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


    public function itemBatch() {
    	return $this->belongsTo('App\Models\ItemBatch','batch_code','batch_code');
   	}	

    
}
