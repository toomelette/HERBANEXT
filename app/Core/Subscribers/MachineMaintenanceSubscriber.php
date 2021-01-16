<?php 

namespace App\Core\Subscribers;


use App\Core\BaseClasses\BaseSubscriber;



class MachineMaintenanceSubscriber extends BaseSubscriber{




    public function __construct(){

        parent::__construct();

    }




    public function subscribe($events){

        $events->listen('machine_maintenance.store', 'App\Core\Subscribers\MachineMaintenanceSubscriber@onStore');
        $events->listen('machine_maintenance.update', 'App\Core\Subscribers\MachineMaintenanceSubscriber@onUpdate');
        $events->listen('machine_maintenance.destroy', 'App\Core\Subscribers\MachineMaintenanceSubscriber@onDestroy');

    }




    public function onStore($machine_mnt){
        
        $this->__cache->deletePattern(''. config('app.name') .'_cache:machine_maintenances:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:machine_maintenances:getAll');

        $this->session->flash('MACHINE_MNT_CREATE_SUCCESS', 'The Maintenance Schedule has been successfully created!');

    }





    public function onUpdate($machine_mnt){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:machine_maintenances:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:machine_maintenances:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:machine_maintenances:findBySlug:'. $machine_mnt->slug .'');

        $this->session->flash('MACHINE_MNT_UPDATE_SUCCESS', 'The Maintenance Schedule has been successfully updated!');
        $this->session->flash('MACHINE_MNT_UPDATE_SUCCESS_SLUG', $machine_mnt->slug);

    }



    public function onDestroy($machine_mnt){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:machine_maintenances:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:machine_maintenances:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:machine_maintenances:findBySlug:'. $machine_mnt->slug .'');

        $this->session->flash('MACHINE_MNT_DELETE_SUCCESS', 'The Maintenance Schedule has been successfully deleted!');
        $this->session->flash('MACHINE_MNT_DELETE_SUCCESS_SLUG', $machine_mnt->slug);

    }





}