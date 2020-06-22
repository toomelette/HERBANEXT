<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class EngrTask extends Model{



    use Sortable;

    protected $table = 'engr_tasks';

    protected $dates = ['created_at', 'updated_at', 'date_from', 'date_to'];

    protected $sortable = ['description', 'location', 'status'];
    
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'engr_task_id' => '',
        'cat' => '',
        'requested_by' => '',
        'unit' => '',
        'location' => '',
        'description' => '',
        'pic' => '',
        'is_allday' => 1,
        'date_from' => null,
        'date_to' => null,
        'color' => '',
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
            $span = '<span class="badge bg-blue">Working .. </span>';
        }elseif ($this->status == 3) {
            $span = '<span class="badge bg-green">Finished</span>';
        }

        return $span;

    }




    // Relationships

    public function engrTaskPersonnel() {
        return $this->hasMany('App\Models\EngrTaskPersonnel','engr_task_id','engr_task_id');
    }


}
