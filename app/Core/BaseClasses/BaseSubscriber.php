<?php 

namespace App\Core\BaseClasses;

use App;
use Session;
use App\Core\Helpers\__cache;


class BaseSubscriber{


    protected $session;
    protected $cacheHelper;



    public function __construct(){

        $this->session = session();
        $this->__cache = App::make(__cache::class);
        
    }





}