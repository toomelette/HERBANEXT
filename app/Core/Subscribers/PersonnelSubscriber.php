<?php 

namespace App\Core\Subscribers;


use App\Core\BaseClasses\BaseSubscriber;



class PersonnelSubscriber extends BaseSubscriber{




    public function __construct(){

        parent::__construct();

    }




    public function subscribe($events){

        $events->listen('personnel.store', 'App\Core\Subscribers\PersonnelSubscriber@onStore');
        $events->listen('personnel.update', 'App\Core\Subscribers\PersonnelSubscriber@onUpdate');
        $events->listen('personnel.destroy', 'App\Core\Subscribers\PersonnelSubscriber@onDestroy');

    }




    public function onStore(){
        
        $this->__cache->deletePattern(''. config('app.name') .'_cache:personnels:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:personnels:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:task_personnel:personnelRatingThisMonth');

        $this->session->flash('PERSONNEL_CREATE_SUCCESS', 'The Personnel has been successfully created!');

    }





    public function onUpdate($personnel){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:personnels:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:personnels:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:personnels:findBySlug:'. $personnel->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:personnels:findByPersonnelId:'. $personnel->personnel_id .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:task_personnel:personnelRatingThisMonth');

        $this->session->flash('PERSONNEL_UPDATE_SUCCESS', 'The Personnel has been successfully updated!');
        $this->session->flash('PERSONNEL_UPDATE_SUCCESS_SLUG', $personnel->slug);

    }



    public function onDestroy($personnel){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:personnels:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:personnels:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:personnels:findBySlug:'. $personnel->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:personnels:findByPersonnelId:'. $personnel->personnel_id .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:task_personnel:personnelRatingThisMonth');

        $this->session->flash('PERSONNEL_DELETE_SUCCESS', 'The Personnel has been successfully deleted!');
        $this->session->flash('PERSONNEL_DELETE_SUCCESS_SLUG', $personnel->slug);

    }





}