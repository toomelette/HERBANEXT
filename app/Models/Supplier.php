<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Supplier extends Model{



    use Sortable;
    protected $table = 'suppliers';
    protected $dates = ['created_at', 'updated_at'];
    public $sortable = ['name', 'description'];
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'supplier_id' => '',
        'name' => '',
        'description' => '',
        'address' => '',
        'contact_email' => '',
        'contact_person' => '',
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];



    /** RELATIONSHIPS **/
    public function item() {
        return $this->hasMany('App\Models\Item','supplier_id','supplier_id');
    }


    
}
