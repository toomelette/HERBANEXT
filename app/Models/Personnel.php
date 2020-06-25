<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class Personnel extends Model{



    use Sortable;

    protected $table = 'personnels';

    protected $dates = ['created_at', 'updated_at'];

    protected $sortable = ['firstname', 'position'];
    
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'personnel_id' => '',
        'avatar_location' => '',
        'firstname' => '',
        'middlename' => '',
        'lastname' => '',
        'position' => '',
        'contact_no' => '',
        'email' => '',
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];




    public function getFullNameAttribute(){
        return ucfirst($this->firstname) .' '. strtoupper(substr($this->middlename, 0, 1)) .'. '. ucfirst($this->lastname);
    }



    public function aveRating(){

        $ave = 0;

        if (!$this->taskPersonnel->isEmpty()) {
                
            $total = 0;
            $num_of_records = 0;

            foreach ($this->taskPersonnel as $data) {

                $total += $data->rating;
                $num_of_records += 1;
            }

            $ave = $total / $num_of_records;

        }

        return number_format($ave, 2);

    }



    // RELATIONSHIPS
    public function taskPersonnel() {
        return $this->hasMany('App\Models\TaskPersonnel','personnel_id','personnel_id');
    }


}
