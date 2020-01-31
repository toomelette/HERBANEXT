<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class Submenu extends Model{
	



	use Sortable;

    protected $table = 'su_submenus';

    protected $dates = ['created_at', 'updated_at'];

    public $sortable = ['name', 'route', 'is_nav'];

    public $timestamps = false;





    protected $attributes = [

        'slug' => '',
        'submenu_id' => '',
        'menu_id' => '',
        'is_nav' => false,
        'name' => '',
        'route' => '',
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];




    /** RELATIONSHIPS **/
    public function menu() {
    	return $this->belongsTo('App\Models\Menu','menu_id','menu_id');
   	}







}
