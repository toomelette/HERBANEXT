<?php
 
namespace App\Core\BaseClasses;


use App;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Core\Helpers\__dataType;
use Illuminate\Cache\Repository as Cache;
use Conversion;


class BaseRepository{



    protected $auth;
    protected $carbon;
    protected $str;
    protected $__dataType;
    protected $cache;
    protected $convertion;




    public function __construct(){
        
        $this->auth = auth();
        $this->carbon = App::make(Carbon::class);
        $this->str = App::make(Str::class);
        $this->__dataType = App::make(__dataType::class);
        $this->cache = App::make(Cache::class);
        $this->convertion = App::make(Conversion::class);
        
    }




}