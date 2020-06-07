<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class Task extends Model{



    use Sortable;

    protected $table = 'tasks';

    protected $dates = ['created_at', 'updated_at', 'date_from', 'date_to'];

    protected $sortable = ['name', 'description', 'date_from', 'status'];
    
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'task_id' => '',
        'item_id' => '',
        'machine_id' => '',
        'name' => '',
        'description' => '',
        'is_allday' => 1,
        'date_from' => null,
        'date_to' => null,
        'status' => 1,
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];




    public function displayStatusSpan(){

        $span = '';

        if ($this->status == 1) {
            $span = '<span class="badge bg-red">Unscheduled</span>';
        }elseif ($this->status == 2) {
            $span = '<span class="badge bg-orange">Pending .. </span>';
        }elseif ($this->status == 3) {
            $span = '<span class="badge bg-green">Finished</span>';
        }

        return $span;

    }




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
