<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Submenu extends Model{
	

    protected $table = 'su_submenus';

    public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'submenu_id' => '',
        'menu_id' => '',
        'is_nav' => false,
        'name' => '',
        'nav_name' => '',
        'route' => '',

    ];




    /** RELATIONSHIPS **/
    public function menu() {
    	return $this->belongsTo('App\Models\Menu','menu_id','menu_id');
   	}







}
