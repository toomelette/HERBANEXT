<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class ItemCategory extends Model{


	use Sortable;

    protected $table = 'item_categories';

    public $sortable = ['name', 'description'];

    protected $dates = ['created_at', 'updated_at'];
    
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'item_category_id' => '',
        'name' => '',
        'description' => '',
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];





    /** RELATIONSHIPS **/
    public function item() {
        return $this->hasMany('App\Models\Item','item_category_id','item_category_id');
    }



 
}
