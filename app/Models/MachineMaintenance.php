<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Carbon;

class MachineMaintenance extends Model{



    use Sortable;

    protected $table = 'machine_maintenance';

    protected $dates = ['created_at', 'updated_at'];

    protected $sortable = ['name', 'description', 'date_from', 'date_to'];
    
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'machine_id' => '',
        'date_from' => null,
        'date_to' => null,
        'time_from' => null,
        'time_to' => null,
        'description' => '',
        'remarks' => '',
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];



    /** RELATIONSHIPS **/
    public function machine() {
        return $this->belongsTo('App\Models\Machine','machine_id','machine_id');
    }
    


}
