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



    public function updateRating($task_personnel_id, $request){
        $task_personnel = $this->findByTaskPersonnelId($task_personnel_id);
        $task_personnel->rating = $request->rating;
        $task_personnel->remarks = $request->remarks;
        $task_personnel->save();
        return $task_personnel;

    }




    public function findByTaskPersonnelId($task_personnel_id){

        $task_personnel = $this->cache->remember('task_personnel:findByTaskPersonnelId:' . $task_personnel_id, 240, 

            function() use ($task_personnel_id){

                return $this->task_personnel->where('task_personnel_id', $task_personnel_id)     
                                            ->first();

            }); 
        
        if(empty($task_personnel)){
            abort(404);
        }

        return $task_personnel;

    }



    public function personnelRatingThisMonth(){

        $task_personnels = $this->cache->remember('task_personnel:personnelRatingThisMonth', 240, function(){

            $month_now = $this->carbon->now()->format('m');

            return $this->task_personnel->select('task_id', 'personnel_id', 'rating')
                                        ->with('task', 'personnel')
                                        ->whereHas('task', function ($model) use ($month_now){
                                            $model->whereMonth('date_to', $month_now);
                                        })
                                        ->get();

        });
        
        return $task_personnels;

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