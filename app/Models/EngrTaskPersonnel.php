<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EngrTaskPersonnel extends Model{



    protected $table = 'engr_task_personnels';
    
	public $timestamps = false;



    protected $attributes = [

        'engr_task_id' => '',
        'personnel_id' => '',
        'engr_task_personnel_id' => '',
        'rating' => 0,
        'remarks' => '',

    ];


    /** RELATIONSHIPS **/
    public function engrTask() {
        return $this->belongsTo('App\Models\EngrTask','engr_task_id','engr_task_id');
    }

    public function personnel() {
        return $this->belongsTo('App\Models\Personnel','personnel_id','personnel_id');
    }

   
}
