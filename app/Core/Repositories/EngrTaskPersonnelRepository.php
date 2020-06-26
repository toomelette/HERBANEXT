<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\EngrTaskPersonnelInterface;


use App\Models\EngrTaskPersonnel;


class EngrTaskPersonnelRepository extends BaseRepository implements EngrTaskPersonnelInterface {
	


    protected $engr_task_personnel;



	public function __construct(EngrTaskPersonnel $engr_task_personnel){
        $this->engr_task_personnel = $engr_task_personnel;
        parent::__construct();
    }



    public function store($engr_task_id, $personnel_id){

        $engr_task_personnel = new EngrTaskPersonnel;
        $engr_task_personnel->engr_task_id = $engr_task_id;
        $engr_task_personnel->personnel_id = $personnel_id;
        $engr_task_personnel->engr_task_personnel_id = $this->getTaskPersonnelIdInc();
        $engr_task_personnel->save();
        return $engr_task_personnel;

    }



    public function updateRating($engr_task_personnel_id, $request){
        $engr_task_personnel = $this->findByTaskPersonnelId($engr_task_personnel_id);
        $engr_task_personnel->rating = $request->rating;
        $engr_task_personnel->remarks = $request->remarks;
        $engr_task_personnel->save();
        return $engr_task_personnel;

    }




    public function findByTaskPersonnelId($engr_task_personnel_id){

        $engr_task_personnel = $this->cache->remember('engr_task_personnel:findByEngrTaskPersonnelId:' . $engr_task_personnel_id, 240, 

            function() use ($engr_task_personnel_id){

                return $this->engr_task_personnel->where('engr_task_personnel_id', $engr_task_personnel_id)     
                                                 ->first();

            }); 
        
        if(empty($engr_task_personnel)){
            abort(404);
        }

        return $engr_task_personnel;

    }



    // public function personnelRatingThisMonth(){

    //     $engr_task_personnels = $this->cache->remember('engr_task_personnel:personnelRatingThisMonth', 240, function(){

    //         $month_now = $this->carbon->now()->format('m');

    //         return $this->engr_task_personnel->select('engr_task_id', 'personnel_id', 'rating')
    //                                     ->with('engr_task', 'personnel')
    //                                     ->whereHas('engr_task', function ($model) use ($month_now){
    //                                         $model->whereMonth('date_to', $month_now);
    //                                     })
    //                                     ->get();

    //     });
        
    //     return $engr_task_personnels;

    // }



    public function getTaskPersonnelIdInc(){

        $id = 'ETP100001';
        $engr_task_personnel = $this->engr_task_personnel->select('engr_task_personnel_id')
                                                         ->orderBy('engr_task_personnel_id', 'desc')
                                                         ->first();

        if($engr_task_personnel != null){
            $num = str_replace('ETP', '', $engr_task_personnel->engr_task_personnel_id) + 1;
            $id = 'ETP' . $num;
        }
        
        return $id;
        
    }





}