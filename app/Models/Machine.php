<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Carbon;

class Machine extends Model{



    use Sortable;

    protected $table = 'machines';

    protected $dates = ['created_at', 'updated_at'];

    protected $sortable = ['name', 'description'];
    
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'machine_id' => '',
        'name' => '',
        'description' => '',
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];
    


}
