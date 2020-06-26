<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskPersonnel extends Model{



    protected $table = 'task_personnels';
    
	public $timestamps = false;



    protected $attributes = [

        'task_id' => '',
        'personnel_id' => '',
        'task_personnel_id' => '',
        'rating' => 0,
        'remarks' => '',

    ];


    /** RELATIONSHIPS **/
    public function task() {
        return $this->belongsTo('App\Models\Task','task_id','task_id');
    }

    public function personnel() {
        return $this->belongsTo('App\Models\Personnel','personnel_id','personnel_id');
    }

   
}
