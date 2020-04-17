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
        $events->listen('task.drop', 'App\Core\Subscribers\TaskSubscriber@onDrop');
        $events->listen('task.resize', 'App\Core\Subscribers\TaskSubscriber@onResize');
        $events->listen('task.event_drop', 'App\Core\Subscribers\TaskSubscriber@onEventDrop');

    }




    public function onStore(){
        
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:getUnscheduled');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:getScheduled');

        $this->session->flash('TASK_CREATE_SUCCESS', 'The Task has been successfully created!');

    }





    public function onUpdate($task){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:getUnscheduled');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:getScheduled');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:findBySlug:'. $task->slug .'');

        $this->session->flash('TASK_UPDATE_SUCCESS', 'The Task has been successfully updated!');
        $this->session->flash('TASK_UPDATE_SUCCESS_SLUG', $task->slug);

    }



    public function onDestroy($task){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:getUnscheduled');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:getScheduled');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:findBySlug:'. $task->slug .'');

        $this->session->flash('TASK_DELETE_SUCCESS', 'The Task has been successfully deleted!');
        $this->session->flash('TASK_DELETE_SUCCESS_SLUG', $task->slug);

    }



    public function onDrop($task){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:getUnscheduled');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:getScheduled');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:findBySlug:'. $task->slug .'');

    }



    public function onResize($task){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:getUnscheduled');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:getScheduled');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:findBySlug:'. $task->slug .'');

    }



    public function onEventDrop($task){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:getUnscheduled');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:getScheduled');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:tasks:findBySlug:'. $task->slug .'');

    }





}