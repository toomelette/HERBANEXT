<?php 

namespace App\Core\Subscribers;


use App\Core\BaseClasses\BaseSubscriber;



class TaskSubscriber extends BaseSubscriber{




    public function __construct(){

        parent::__construct();

    }




    public function subscribe($events){

        $events->listen('task.store', 'App\Core\Subscribers\TaskSubscriber@onStore');
        $events->listen('task.update', 'App\Core\Subscribers\TaskSubscriber@onUpdate');
        $events->listen('task.destroy', 'App\Core\Subscribers\TaskSubscriber@onDestroy');
        $events->listen('task.rate_personnel', 'App\Core\Subscribers\TaskSubscriber@onRatePersonnel');

    }




    public function onStore(){
        
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:fetchByScheduled:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:getUnscheduled');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:getScheduled');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:countNew');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:task_personnel:personnelRatingThisMonth');

        $this->session->flash('TASK_CREATE_SUCCESS', 'The Task has been successfully created!');

    }





    public function onUpdate($task){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:fetchByScheduled:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:getUnscheduled');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:getScheduled');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:findBySlug:'. $task->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:task_personnel:personnelRatingThisMonth');

        $this->session->flash('TASK_UPDATE_SUCCESS', 'The Task has been successfully updated!');
        $this->session->flash('TASK_UPDATE_SUCCESS_SLUG', $task->slug);

    }




    public function onDestroy($task){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:fetchByScheduled:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:getUnscheduled');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:getScheduled');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:findBySlug:'. $task->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:countNew');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:task_personnel:personnelRatingThisMonth');

        $this->session->flash('TASK_DELETE_SUCCESS', 'The Task has been successfully deleted!');
        $this->session->flash('TASK_DELETE_SUCCESS_SLUG', $task->slug);

    }


    

    public function onRatePersonnel($task_personnel){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:task_personnel:findByTaskPersonnelId:'. $task_personnel->task_personnel_id .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:task_personnel:personnelRatingThisMonth');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:findBySlug:'. optional($task_personnel->task)->slug .'');

        $this->session->flash('TASK_PERSONNEL_RATING_SUCCESS', 'Your rating has been successfully submitted!');

    }





}