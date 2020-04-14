<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskMachine extends Model{



    protected $table = 'task_machines';
    
	public $timestamps = false;



    protected $attributes = [

        'task_id' => '',
        'machine_id' => '',
        'task_machine_id' => '',

    ];



    /** RELATIONSHIPS **/
    public function task() {
        return $this->belongsTo('App\Models\Task','task_id','task_id');
    }


    public function machine() {
        return $this->belongsTo('App\Models\Machine','machine_id','machine_id');
    }

   
}
