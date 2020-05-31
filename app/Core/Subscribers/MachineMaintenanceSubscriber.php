<?php 

namespace App\Core\Subscribers;


use App\Core\BaseClasses\BaseSubscriber;



class MachineMaintenanceSubscriber extends BaseSubscriber{




    public function __construct(){

        parent::__construct();

    }




    public function subscribe($events){

        $events->listen('machine_mnt.store', 'App\Core\Subscribers\MachineMaintenanceSubscriber@onStore');
        $events->listen('machine_mnt.update', 'App\Core\Subscribers\MachineMaintenanceSubscriber@onUpdate');
        $events->listen('machine_mnt.destroy', 'App\Core\Subscribers\MachineMaintenanceSubscriber@onDestroy');

    }




    public function onStore($machine_mnt){
        
        $this->__cache->deletePattern(''. config('app.name') .'_cache:machine_maintenance:fetchByMachineId:'.$machine_mnt->machine_id.':*');

        $this->session->flash('MACHINE_MNT_CREATE_SUCCESS', 'The Machine Maintenance has been successfully created!');

    }





    public function onUpdate($machine_mnt){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:machine_maintenance:fetchByMachineId:'.$machine_mnt->machine_id.':*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:machine_maintenance:findBySlug:'. $machine_mnt->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:machine_maintenance:getBySlug:'. $machine_mnt->slug .'');

        $this->session->flash('MACHINE_MNT_UPDATE_SUCCESS', 'The Machine Maintenance has been successfully updated!');
        $this->session->flash('MACHINE_MNT_UPDATE_SUCCESS_SLUG', $machine_mnt->slug);

    }



    public function onDestroy($machine_mnt){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:machine_maintenance:fetchByMachineId:'.$machine_mnt->machine_id.':*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:machine_maintenance:findBySlug:'. $machine_mnt->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:machine_maintenance:getBySlug:'. $machine_mnt->slug .'');

        $this->session->flash('MACHINE_MNT_DELETE_SUCCESS', 'The Machine Maintenance has been successfully deleted!');
        $this->session->flash('MACHINE_MNT_DELETE_SUCCESS_SLUG', $machine_mnt->slug);

    }





}