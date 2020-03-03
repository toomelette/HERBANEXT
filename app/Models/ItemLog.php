<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class ItemLog extends Model{

    use Sortable;

    protected $table = 'item_logs';

    protected $dates = ['created_at', 'updated_at'];

    public $sortable = ['product_code', 'transaction_type', 'amount', 'unit', 'datetime'];
    
	public $timestamps = false;



    protected $attributes = [

        'product_code' => '',
    	'transaction_type' => false,
        'amount' => 0.000,
        'unit' => '',
        'balance_before_transaction' => 0.000,
        'datetime' => null,
        'ip_address' => '',
        'user_id' => '',

    ];





    /** RELATIONSHIPS **/
    public function item() {
    	return $this->belongsTo('App\Models\Item','product_code','product_code');
   	}		


    public function user() {
        return $this->belongsTo('App\Models\user','user_id','user_id');
    }   


    
}