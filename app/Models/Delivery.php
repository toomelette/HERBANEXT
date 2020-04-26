<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Delivery extends Model{



    use Sortable;
    protected $table = 'deliveries';
    protected $dates = ['date', 'created_at', 'updated_at'];
    public $sortable = ['delivery_code', 'description', 'date', 'updated_at'];
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'delivery_id' => '',
        'delivery_code' => '',
        'description' => '',
        'date' => null,
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];



    /** RELATIONSHIPS **/
    public function deliveryJobOrder() {
        return $this->hasMany('App\Models\DeliveryJobOrder','delivery_id','delivery_id');
    }


    
}
