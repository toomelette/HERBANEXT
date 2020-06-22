<?php
 
namespace App\Core\Services;


use App\Core\Interfaces\EngrTaskInterface;
use App\Core\Interfaces\EngrTaskPersonnelInterface;
use App\Core\BaseClasses\BaseService;


class EngrTaskService extends BaseService{



    protected $engr_task_repo;
    protected $engr_task_personnel_repo;



    public function __construct(EngrTaskInterface $engr_task_repo, 
                                EngrTaskPersonnelInterface $engr_task_personnel_repo){

        $this->engr_task_repo = $engr_task_repo;
        $this->engr_task_personnel_repo = $engr_task_personnel_repo;
        parent::__construct();

    }



    // public function fetch($request){

    //     $engr_tasks = $this->engr_task_repo->fetch($request);
    //     $request->flash();
    //     return view('dashboard.engr_task.index')->with('engr_tasks', $engr_tasks);

    // }



    // public function scheduling(){

    //     $unscheduled_engr_tasks = $this->engr_task_repo->getUnscheduled();
    //     $scheduled_engr_tasks = $this->engr_task_repo->getScheduled();

    //     return view('dashboard.engr_task.scheduling')->with([
    //         'unscheduled_engr_tasks' => $unscheduled_engr_tasks,
    //         'scheduled_engr_tasks' => $scheduled_engr_tasks,
    //     ]);

    // }



    // public function calendar(){

    //     $scheduled_engr_tasks = $this->engr_task_repo->getScheduled();
    //     return view('dashboard.engr_task.calendar')->with('scheduled_engr_tasks', $scheduled_engr_tasks);

    // }



    public function store($request){    

        $engr_task = $this->engr_task_repo->store($request);

        if(!empty($request->personnels)){
            foreach ($request->personnels as $data) {
                $this->engr_task_personnel_repo->store($engr_task->engr_task_id, $data);
            }
        }

        $this->event->fire('engr_task.store');
        return redirect()->back();

    }



    // public function edit($slug){

    //     $engr_task = $this->engr_task_repo->findbySlug($slug);
    //     return view('dashboard.engr_task.edit')->with('engr_task', $engr_task);

    // }



    // public function update($request, $slug){

    //     $engr_task = $this->engr_task_repo->update($request, $slug);

    //     if(!empty($request->personnels)){
    //         foreach ($request->personnels as $data) {
    //             $this->task_personnel_repo->store($engr_task->engr_task_id, $data);
    //         }
    //     }
        
    //     $this->event->fire('engr_task.update', $engr_task);
    //     return redirect()->route('dashboard.engr_task.index');

    // }



    // public function updateFinished($slug){

    //     $engr_task = $this->engr_task_repo->updateStatus($slug, 3);
        
    //     $this->event->fire('engr_task.update', $engr_task);
    //     return redirect()->route('dashboard.engr_task.index');

    // }



    // public function updateUnfinished($slug){

    //     $engr_task = $this->engr_task_repo->updateStatus($slug, 2);
        
    //     $this->event->fire('engr_task.update', $engr_task);
    //     return redirect()->route('dashboard.engr_task.index');

    // }



    // public function destroy($slug){

    //     $engr_task = $this->engr_task_repo->destroy($slug);
    //     $this->event->fire('engr_task.destroy', $engr_task);
    //     return redirect()->back();

    // }



    // public function ratePersonnel($slug){

    //     $engr_task = $this->engr_task_repo->findbySlug($slug);
    //     return view('dashboard.engr_task.rate_personnel')->with('engr_task', $engr_task);

    // }



    // public function ratePersonnelPost($request, $task_personnel_id){

    //     $task_personnel = $this->task_personnel_repo->updateRating($task_personnel_id, $request->rating);

    //     $this->event->fire('engr_task.rate_personnel', $task_personnel);
    //     return redirect()->back();

    // }



}