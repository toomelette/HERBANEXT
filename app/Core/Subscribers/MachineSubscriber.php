<?php 

namespace App\Core\Subscribers;


use App\Core\BaseClasses\BaseSubscriber;



class MachineSubscriber extends BaseSubscriber{




    public function __construct(){

        parent::__construct();

    }




    public function subscribe($events){

        $events->listen('machine.store', 'App\Core\Subscribers\MachineSubscriber@onStore');
        $events->listen('machine.update', 'App\Core\Subscribers\MachineSubscriber@onUpdate');
        $events->listen('machine.destroy', 'App\Core\Subscribers\MachineSubscriber@onDestroy');

    }




    public function onStore(){
        
        $this->__cache->deletePattern(''. config('app.name') .'_cache:machines:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:machines:getAll');

        $this->session->flash('MACHINE_CREATE_SUCCESS', 'The Machine has been successfully created!');

    }





    public function onUpdate($machine){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:machines:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:machines:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:machines:findBySlug:'. $machine->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:machines:findByMachineId:'. $machine->machine_id .'');

        $this->session->flash('MACHINE_UPDATE_SUCCESS', 'The Machine has been successfully updated!');
        $this->session->flash('MACHINE_UPDATE_SUCCESS_SLUG', $machine->slug);

    }



    public function onDestroy($machine){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:machines:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:machines:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:machines:findBySlug:'. $machine->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:machines:findByMachineId:'. $machine->machine_id .'');

        $this->session->flash('MACHINE_DELETE_SUCCESS', 'The Machine has been successfully deleted!');
        $this->session->flash('MACHINE_DELETE_SUCCESS_SLUG', $machine->slug);

    }





}