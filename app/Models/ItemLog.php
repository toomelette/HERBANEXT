<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class ItemLog extends Model{

    use Sortable;

    protected $table = 'item_logs';

    protected $dates = ['created_at', 'updated_at'];

    public $sortable = ['product_code', 'transaction_type', 'amount', 'unit', 'datetime', 'remarks'];
    
	public $timestamps = false;



    protected $attributes = [
        'item_id' => '',
        'batch_id' => '',
        'product_code' => '',
        'item_name' => '',
    	'transaction_type' => false,
        'amount' => 0.000,
        'unit' => '',
        'balance_before_transaction' => 0.000,
        'remarks' => '',
        'datetime' => null,
        'ip_address' => '',
        'user_id' => '',

    ];




    public function displayAmount(){

        $txt = '';

        if (optional($this->item)->unit != 'PCS') {
            if ($this->transaction_type == 1) {
                $txt = '<span class="text-green">'. number_format($this->amount, 3) .' '. $this->unit .'</span>';
            }else{
                $txt = '<span class="text-red">'. number_format($this->amount, 3) .' '. $this->unit .'</span>';
            }
        }else{
            if ($this->transaction_type == 1) {
                $txt = '<span class="text-green">'. number_format($this->amount) .' '. $this->unit .'</span>';
            }else{
                $txt = '<span class="text-red">'. number_format($this->amount) .' '. $this->unit .'</span>';
            }
        }

        return $txt;

    }





    /** RELATIONSHIPS **/
    public function item() {
    	return $this->belongsTo('App\Models\Item','item_id','item_id');
    }	
       

    public function itemBatch() {
        return $this->belongsTo('App\Models\ItemBatch','batch_id','batch_id');
    }		


    public function user() {
        return $this->belongsTo('App\Models\user','user_id','user_id');
    }   


    
}
