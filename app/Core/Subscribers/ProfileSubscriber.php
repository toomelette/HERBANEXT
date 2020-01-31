<?php 

namespace App\Core\Subscribers;


use App\Core\BaseClasses\BaseSubscriber;



class ProfileSubscriber extends BaseSubscriber{




	public function __construct(){

        parent::__construct();

    }




	public function subscribe($events){

		$events->listen('profile.update_account_username', 'App\Core\Subscribers\ProfileSubscriber@onUpdateAccountUsername');
		$events->listen('profile.update_account_password', 'App\Core\Subscribers\ProfileSubscriber@onUpdateAccountPassword');
		$events->listen('profile.update_account_color', 'App\Core\Subscribers\ProfileSubscriber@onUpdateAccountColor');

	}





    public function onUpdateAccountUsername($user){


         $this->__cache->deletePattern(''. config('app.name') .'_cache:users:fetch:*');
         $this->__cache->deletePattern(''. config('app.name') .'_cache:users:findBySlug:'. $user->slug .'');

        $this->session->flash('PROFILE_UPDATE_USERNAME_SUCCESS', 'Your username has been successfully updated! Please sign in again.');

    }





    public function onUpdateAccountPassword($user){

         $this->__cache->deletePattern(''. config('app.name') .'_cache:users:fetch:*');
         $this->__cache->deletePattern(''. config('app.name') .'_cache:users:findBySlug:'. $user->slug .'');

        $this->session->flash('PROFILE_UPDATE_PASSWORD_SUCCESS', 'Your password has been successfully updated! Please sign in again.');

    }





    public function onUpdateAccountColor($user){

         $this->__cache->deletePattern(''. config('app.name') .'_cache:users:fetch:*');
         $this->__cache->deletePattern(''. config('app.name') .'_cache:users:findBySlug:'. $user->slug .'');

        $this->session->flash('PROFILE_UPDATE_COLOR_SUCCESS', 'Color Scheme successfully set!');

    }





}