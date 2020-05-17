<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class FinishingOrder extends Model{



    use Sortable;
    protected $table = 'finishing_orders';
    protected $dates = ['processing_date', 'expired_date', 'requested_date', 'created_at', 'updated_at'];
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'fo_id' => '',
        'fo_no' => '',
        'master_fo_no' => '',
        'item_id' => '',
        'po_id' => '',
        'jo_id' => '',
        'client' => '',
        'shelf_life' => '',
        'processing_date' => null,
        'expired_date' => null,
        'requested_by' => '',
        'requested_date' => null,
        'status' => '',
        'issued_by_date' => '',
        'checked_by_date' => '',
        'received_by_date' => '',
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];



    /** RELATIONSHIPS **/
    public function purchaseOrder() {
    	return $this->belongsTo('App\Models\PurchaseOrder','po_id','po_id');
   	}

    public function jobOrder() {
        return $this->belongsTo('App\Models\JobOrder','jo_id','jo_id');
    }

    public function finishingOrderPackMat() {
        return $this->hasMany('App\Models\FinishingOrderPackMat','fo_id','fo_id');
    }


    
}
