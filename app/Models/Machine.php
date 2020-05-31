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



    public function maintenanceStatus(){

        $count = 0;
        $status = false;

        if (!$this->machineMaintenance->isEmpty()) {

            foreach ($this->machineMaintenance as $data) {

                $from = Carbon::parse($data->date_from)->format('Y-m-d');
                $to = Carbon::parse($data->date_to)->format('Y-m-d');

                $from = Carbon::createFromFormat('Y-m-d', $from);
                $to = Carbon::createFromFormat('Y-m-d', $to);

                $is_under_mnt = Carbon::now()->between($from, $to);

                if ($is_under_mnt == true) {
                    $count += 1;
                }

            }
            
        }

        if ($count > 0) {
            $status = true;
        }

        return $status;

    }



    public function displayMaintenanceStatusSpan(){

        $span = '<span class=" badge bg-green">Operational<span>';

        if ($this->maintenanceStatus() == true) {
            $span = '<span class=" badge bg-orange">Under Maintenance<span>';
        }

        return $span;

    }



    public function displayMaintenanceStatusText(){

        $txt = 'Operational';

        if ($this->maintenanceStatus() == true) {
            $txt = 'Under Maintenance';
        }

        return $txt;

    }


    // Relationships
    public function machineMaintenance() {
        return $this->hasMany('App\Models\MachineMaintenance','machine_id','machine_id');
    }


}
