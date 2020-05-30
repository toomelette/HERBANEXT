<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class MachineMaintenance extends Model{



    use Sortable;

    protected $table = 'machine_maintenance';

    protected $dates = ['date_from', 'date_to', 'created_at', 'updated_at'];
    
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'machine_id' => '',
        'date_from' => null,
        'date_to' => null,
        'description' => '',
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];



}
