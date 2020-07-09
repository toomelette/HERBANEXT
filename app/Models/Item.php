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
        'item_id' => '',
        'product_code' => '',
        'supplier_id' => '',
        'item_category_id' => '',
        'item_type_id' => '',
        'unit_type_id' => '',
        'name' => '',
        'description' => '',
        'beginning_balance' => 0.000,
        'current_balance' => 0.000,
        'unit' => '',
        'batch_size' => '',
        'price' => 0.0000,
        'min_req_qty' => 0.000,
        'is_incoming' => false,
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];




    public function displayCurrentBalance(){

        $txt = '';

        if ($this->min_req_qty > $this->current_balance) {
                
            if ($this->unit != 'PCS') {
                $txt = '<span class="text-red">'. number_format($this->current_balance, 3) .' '. $this->unit .'<span>';
            }else{
                $txt = '<span class="text-red">'. number_format($this->current_balance) .' '. $this->unit .'<span>';
            }

        }else{

            if ($this->unit != 'PCS') {
                $txt = '<span class="text-green">'. number_format($this->current_balance, 3) .' '. $this->unit .'<span>';
            }else{
                $txt = '<span class="text-green">'. number_format($this->current_balance) .' '. $this->unit .'<span>';
            }

        }

        return $txt;

    }




    public function displayPendingCheckout(){

        $txt = '';
        $amount = 0.00;

        foreach ($this->purchaseOrderItem as $data) {
            if ($data->isJOCompleted() == true) {
                $amount += $data->amount;
            }
        }

        if ($this->unit != 'PCS') {
            $txt = '<span class="text-yellow">'. number_format($amount, 3) .' '. $this->unit .'<span>';
        }else{
            $txt = '<span class="text-yellow">'. number_format($amount) .' '. $this->unit .'<span>';
        }

        return $txt;

    }




    /** RELATIONSHIPS **/
    public function itemBatch() {
    	return $this->hasMany('App\Models\ItemBatch','item_id','item_id');
   	}


    public function itemLog() {
        return $this->hasMany('App\Models\ItemLog','item_id','item_id');
    }


    public function itemCategory() {
        return $this->belongsTo('App\Models\ItemCategory','item_category_id','item_category_id');
    }


    public function itemType() {
        return $this->belongsTo('App\Models\ItemType','item_type_id','item_type_id');
    }


    public function purchaseOrderItem() {
        return $this->hasMany('App\Models\PurchaseOrderItem','item_id','item_id');
    }


    public function itemRawMat() {
        return $this->hasMany('App\Models\ItemRawMat','item_id','item_id');
    }


    public function itemPackMat() {
        return $this->hasMany('App\Models\ItemPackMat','item_id','item_id');
    }


    public function supplier() {
        return $this->belongsTo('App\Models\Supplier','supplier_id','supplier_id');
    }




    
}
