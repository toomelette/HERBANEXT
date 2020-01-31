<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class Menu extends Model{





    use Sortable;

    protected $table = 'su_menus';

    protected $dates = ['created_at', 'updated_at'];
    
	public $timestamps = false;





    protected $attributes = [

        'slug' => '',
        'menu_id' => '',
        'name' => '',
        'route' => '',
        'icon' => '',
        'is_menu' => false,
        'is_dropdown' => false,
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];





    /** RELATIONSHIPS **/
    public function user() {
    	return $this->belongsTo('App\Models\User','user_id','user_id');
   	}




    public function submenu() {
    	return $this->hasMany('App\Models\Submenu','menu_id','menu_id');
   	}

    





}
