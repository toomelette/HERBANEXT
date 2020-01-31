<?php

namespace App\Http\Controllers;


use App\Core\Services\HomeService;



class HomeController extends Controller{
    



	protected $home;




    public function __construct(HomeService $home){

        $this->home = $home;

    }





    public function index(){

    	return $this->home->view();

    }
    





}
