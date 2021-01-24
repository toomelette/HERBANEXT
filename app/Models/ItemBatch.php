<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Carbon;

class ItemBatch extends Model{

    
    use Sortable;

    protected $table = 'item_batches';

    protected $dates = ['expiry_date', 'created_at', 'updated_at'];
    
	public $timestamps = false;



    protected $attributes = [
        
        'batch_id' => '',
        'item_id' => '',
        'product_code' => '',
    	'batch_code' => '',
        'amount' => 0.000,
        'unit' => '',
        'expiry_date' => null,
        'remarks' => '',
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];




    public function displayAmount(){

        $amount = '';

        if ($this->unit == 'PCS') {
            $amount = number_format($this->amount) .' '. $this->unit;
        }else{
            $amount = number_format($this->amount, 3) .' '. $this->unit;
        }

        return $amount;

    }




    public function isAboutToExpire(){

        if ($this->expiry_date <= Carbon::now()->format('Y-m-d')) {
            return false;
        }elseif ($this->expiry_date->subMonths(6) <= Carbon::now()->format('Y-m-d')) {
            if ($this->amount > 0) {
                return true;
            }
        }

        return false;

    }




    public function displayExpiryStatusSpan(){

        $span = '';

        if ($this->expiry_date <= Carbon::now()->format('Y-m-d')) {
            $span = '<span class="badge bg-red">expired on '. $this->expiry_date->format('F d, Y') .'</span>';
        }elseif($this->expiry_date->subMonths(6) <= Carbon::now()->format('Y-m-d')){
            $span = '<span class="badge bg-orange">about to expire on or before '. $this->expiry_date->format('F d, Y') .'</span>';
        }else{
            $span = '<span class="badge bg-green">'. $this->expiry_date->format('F d, Y') .'</span>';
        }

        return $span;

    }




    /** RELATIONSHIPS **/
    public function item() {
    	return $this->belongsTo('App\Models\Item','item_id','item_id');
    }
       
    
    public function itemLog() {
        return $this->hasMany('App\Models\ItemLog','batch_id','batch_id');
    }






    
}
