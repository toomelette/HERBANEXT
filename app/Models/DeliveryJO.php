<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryJO extends Model{



    protected $table = 'delivery_jo';    
	public $timestamps = false;
 


    protected $attributes = [

        'delivery_id' => '',
        'jo_id' => '',
    ];



    /** RELATIONSHIPS **/
    public function jobOrder() {
        return $this->belongsTo('App\Models\JobOrder','jo_id','jo_id');
    }

    public function delivery() {
    	return $this->belongsTo('App\Models\Delivery','delivery_id','delivery_id');
   	}



}
