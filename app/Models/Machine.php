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
        'code' => '',
        'name' => '',
        'location' => '',
        'description' => '',
        'status' => false,
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];
    

    



    public function displayStatus(){

        $string = '';

        if ($this->status == 0 || $this->status == null) {
            $string = '<span class="badge bg-red">Unavailable</span>';
        }elseif($this->status == 1){
            if($this->isUnderMaintenance() == 1){
                $string = '<span class="badge bg-orange">Under Maintenance</span>';
            }else{
                $string = '<span class="badge bg-green">Available</span>';
            }
        }

        return $string;

    }



    public function isUnderMaintenance(){

        $is_um = 0;

        foreach ($this->machineMaintenance as $data) {
            
            $datetime_from = $data->date_from .' '. $data->time_from;
            $datetime_to = $data->date_to .' '. $data->time_to;
            $start_datetime = Carbon::createFromFormat('Y-m-d H:i:s', $datetime_from);
            $end_datetime = Carbon::createFromFormat('Y-m-d H:i:s', $datetime_to);
            
            $check_date = Carbon::now()->between($start_datetime, $end_datetime);
            
            $is_um = $check_date == true ? 1 : 0;

        }

        return $is_um;

    }



    /** RELATIONSHIPS **/
    public function machineMaintenance() {
        return $this->hasMany('App\Models\MachineMaintenance','machine_id','machine_id');
    }


}
