<?php
 
namespace App\Core\Services;


use App\Core\Interfaces\UserInterface;
use App\Core\BaseClasses\BaseService;



class HomeService extends BaseService{



    protected $user_repo;



    public function __construct(UserInterface $user_repo){

        $this->user_repo = $user_repo;
        parent::__construct();

    }





    public function view(){

        return view('dashboard.home.index');

    }








}