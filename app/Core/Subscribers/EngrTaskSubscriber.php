<?php 

namespace App\Core\Subscribers;


use App\Core\BaseClasses\BaseSubscriber;



class EngrTaskSubscriber extends BaseSubscriber{




    public function __construct(){

        parent::__construct();

    }




    public function subscribe($events){

        $events->listen('engr_task.store', 'App\Core\Subscribers\EngrTaskSubscriber@onStore');
        $events->listen('engr_task.update', 'App\Core\Subscribers\EngrTaskSubscriber@onUpdate');
        $events->listen('engr_task.destroy', 'App\Core\Subscribers\EngrTaskSubscriber@onDestroy');
        $events->listen('engr_task.drop', 'App\Core\Subscribers\EngrTaskSubscriber@onDrop');
        $events->listen('engr_task.resize', 'App\Core\Subscribers\EngrTaskSubscriber@onResize');
        $events->listen('engr_task.event_drop', 'App\Core\Subscribers\EngrTaskSubscriber@onEventDrop');
        $events->listen('engr_task.rate_personnel', 'App\Core\Subscribers\EngrTaskSubscriber@onRatePersonnel');

    }




    public function onStore(){
        
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:getUnscheduledJO');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:getUnscheduledDA');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:getScheduled');
        // $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:countNew');
        // $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_task_personnel:personnelRatingThisMonth');

        $this->session->flash('ENGR_TASK_CREATE_SUCCESS', 'The Engineering Task has been successfully created!');

    }





    public function onUpdate($engr_task){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:findBySlug:'. $engr_task->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:getUnscheduledJO');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:getUnscheduledDA');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:getScheduled');
        // $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_task_personnel:personnelRatingThisMonth');

        $this->session->flash('ENGR_TASK_UPDATE_SUCCESS', 'The Engineering Task has been successfully updated!');
        $this->session->flash('ENGR_TASK_UPDATE_SUCCESS_SLUG', $engr_task->slug);

    }



    public function onDestroy($engr_task){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:findBySlug:'. $engr_task->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:getUnscheduledJO');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:getUnscheduledDA');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:getScheduled');
        //$this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:countNew');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_task_personnel:personnelRatingThisMonth');

        $this->session->flash('ENGR_TASK_DELETE_SUCCESS', 'The Engineering Task has been successfully deleted!');
        $this->session->flash('ENGR_TASK_DELETE_SUCCESS_SLUG', $engr_task->slug);

    }



    public function onDrop($engr_task){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:getUnscheduledJO');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:getUnscheduledDA');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:getScheduled');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:findBySlug:'. $engr_task->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_task_personnel:personnelRatingThisMonth');

    }



    public function onResize($engr_task){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:getUnscheduledJO');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:getUnscheduledDA');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:getScheduled');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:findBySlug:'. $engr_task->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_task_personnel:personnelRatingThisMonth');

    }



    public function onEventDrop($engr_task){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:getUnscheduledJO');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:getUnscheduledDA');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:getScheduled');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:findBySlug:'. $engr_task->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_task_personnel:personnelRatingThisMonth');

    }



    public function onRatePersonnel($engr_task_personnel){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_task_personnel:findByEngrTaskPersonnelId:'. $engr_task_personnel->engr_task_personnel_id .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_task_personnel:personnelRatingThisMonth');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:engr_tasks:findBySlug:'. optional($engr_task_personnel->engrTask)->slug .'');

        $this->session->flash('ENGR_TASK_PERSONNEL_RATING_SUCCESS', 'Your rating has been successfully submitted!');

    }





}