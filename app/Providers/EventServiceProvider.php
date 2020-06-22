<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider{


   
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
    ];




    public function boot(){

        parent::boot();

    }




    protected $subscribe = [

        'App\Core\Subscribers\UserSubscriber',
        'App\Core\Subscribers\ProfileSubscriber',
        'App\Core\Subscribers\MenuSubscriber',
        'App\Core\Subscribers\ItemSubscriber',
        'App\Core\Subscribers\ItemCategorySubscriber',
        'App\Core\Subscribers\ItemTypeSubscriber',
        'App\Core\Subscribers\PurchaseOrderSubscriber',
        'App\Core\Subscribers\JobOrderSubscriber',
        'App\Core\Subscribers\ManufacturingOrderSubscriber',
        'App\Core\Subscribers\FinishingOrderSubscriber',
        'App\Core\Subscribers\PersonnelSubscriber',
        'App\Core\Subscribers\MachineSubscriber',
        'App\Core\Subscribers\TaskSubscriber',
        'App\Core\Subscribers\DeliverySubscriber',
        'App\Core\Subscribers\SupplierSubscriber',
        'App\Core\Subscribers\MachineMaintenanceSubscriber',
        'App\Core\Subscribers\EngrTaskSubscriber',
        
    ];





}
