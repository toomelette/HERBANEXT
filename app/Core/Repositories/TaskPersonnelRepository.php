<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\TaskPersonnelInterface;


use App\Models\TaskPersonnel;


class TaskPersonnelRepository extends BaseRepository implements TaskPersonnelInterface {
	


    protected $task_personnel;



	public function __construct(TaskPersonnel $task_personnel){
        $this->task_personnel = $task_personnel;
        parent::__construct();
    }



    public function store($task_id, $personnel_id){

        $task_personnel = new TaskPersonnel;
        $task_personnel->task_id = $task_id;
        $task_personnel->personnel_id = $personnel_id;
        $task_personnel->task_personnel_id = $this->getTaskPersonnelIdInc();
        $task_personnel->save();
        return $task_personnel;

    }



    public function getTaskPersonnelIdInc(){

        $id = 'TP100001';
        $task_personnel = $this->task_personnel->select('task_personnel_id')
                                               ->orderBy('task_personnel_id', 'desc')
                                               ->first();

        if($task_personnel != null){
            $num = str_replace('TP', '', $task_personnel->task_personnel_id) + 1;
            $id = 'TP' . $num;
        }
        
        return $id;
        
    }



}