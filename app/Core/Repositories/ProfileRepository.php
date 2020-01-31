<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\ProfileInterface;
use App\Core\Interfaces\UserInterface;


use Hash;


class ProfileRepository extends BaseRepository implements ProfileInterface {
	


    protected $user_repo;



	public function __construct(UserInterface $user_repo){

        $this->user_repo = $user_repo;
        parent::__construct();

    }






    public function updateUsername($request, $slug){

        $user = $this->user_repo->findBySlug($slug);
        $user->username = $request->username;
        $user->is_online = 0;
        $user->save();

        return $user;

    }





    public function updatePassword($request, $slug){

        $user = $this->user_repo->findBySlug($slug);
        $user->password = Hash::make($request->password);
        $user->is_online = 0;
        $user->save();

        return $user;

    }





    public function updateColor($request, $slug){
        
        $user = $this->user_repo->findBySlug($slug);
        $user->color = $request->color;
        $user->save();

        return $user;

    }






}