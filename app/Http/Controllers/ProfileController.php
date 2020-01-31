<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Core\Services\ProfileService;
use App\Http\Requests\Profile\ProfileUpdateAccountUsernameRequest;
use App\Http\Requests\Profile\ProfileUpdateAccountPasswordRequest;
use App\Http\Requests\Profile\ProfileUpdateAccountColorRequest;


class ProfileController extends Controller{



	protected $profile_service; 



    public function __construct(ProfileService $profile_service){

        $this->profile_service = $profile_service;

    }




	public function details(){

        return view('dashboard.profile.details');
        
    }




    public function updateAccountUsername(ProfileUpdateAccountUsernameRequest $request, $slug){

        return $this->profile_service->updateAccountUsername($request, $slug);
        
    }




    public function updateAccountPassword(ProfileUpdateAccountPasswordRequest $request, $slug){

        return $this->profile_service->updateAccountPassword($request, $slug);
        
    }


    

    public function updateAccountColor(ProfileUpdateAccountColorRequest $request, $slug){

        return $this->profile_service->updateAccountColor($request, $slug);
        
    }


    

    public function printPds($slug, $page){

        return $this->profile_service->printPds($slug, $page);
        
    }





}
