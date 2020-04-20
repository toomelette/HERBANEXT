<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class ItemType extends Model{


	use Sortable;

    protected $table = 'item_types';

    public $sortable = ['name', 'percent'];

    protected $dates = ['created_at', 'updated_at'];
    
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'item_type_id' => '',
        'name' => '',
        'percent' => 0,
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];





    /** RELATIONSHIPS **/
    public function item() {
        return $this->hasMany('App\Models\Item','item_type_id','item_type_id');
    }


    public function jobOrder() {
        return $this->hasMany('App\Models\JobOrder','item_type_id','item_type_id');
    }


    
}
