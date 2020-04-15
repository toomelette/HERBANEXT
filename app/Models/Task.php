<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class Task extends Model{



    use Sortable;

    protected $table = 'tasks';

    protected $dates = ['created_at', 'updated_at'];

    protected $sortable = ['name', 'description', 'date_from', 'is_scheduled'];
    
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'task_id' => '',
        'item_id' => '',
        'machine_id' => '',
        'name' => '',
        'description' => '',
        'date_from' => null,
        'date_to' => null,
        'is_scheduled' => false,
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];


    // Relationships
    public function item() {
        return $this->belongsTo('App\Models\Item','item_id','item_id');
    }

    public function machine() {
        return $this->belongsTo('App\Models\Machine','machine_id','machine_id');
    }

    public function taskPersonnel() {
        return $this->hasMany('App\Models\TaskPersonnel','task_id','task_id');
    }


}
