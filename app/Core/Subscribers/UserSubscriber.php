<?php 

namespace App\Core\Subscribers;


use App\Core\BaseClasses\BaseSubscriber;



class UserSubscriber extends BaseSubscriber{




	public function __construct(){

        parent::__construct();

    }




	public function subscribe($events){

		$events->listen('user.store', 'App\Core\Subscribers\UserSubscriber@onStore');
        $events->listen('user.update', 'App\Core\Subscribers\UserSubscriber@onUpdate');
        $events->listen('user.destroy', 'App\Core\Subscribers\UserSubscriber@onDestroy');
        $events->listen('user.activate', 'App\Core\Subscribers\UserSubscriber@onActivate');
        $events->listen('user.deactivate', 'App\Core\Subscribers\UserSubscriber@onDeactivate');
        $events->listen('user.logout', 'App\Core\Subscribers\UserSubscriber@onLogout');
        $events->listen('user.reset_password_post', 'App\Core\Subscribers\UserSubscriber@onResetPasswordPost');
        $events->listen('user.sync_employee_post', 'App\Core\Subscribers\UserSubscriber@onSyncEmployeePost');
        $events->listen('user.unsync_employee', 'App\Core\Subscribers\UserSubscriber@onUnsyncEmployee');

	}





	public function onStore(){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:users:fetch:*');
        
        $this->session->flash('USER_CREATE_SUCCESS', 'The User has been successfully created!');
        
	}





    public function onUpdate($user){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:users:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:users:findBySlug:'. $user->slug .'');

        $this->__cache->deletePattern(''. config('app.name') .'_cache:user_menus:getByUserId:'. $user->user_id .':*');

        $this->__cache->deletePattern(''. config('app.name') .'_cache:nav:user_menus:byUserId:'. $user->user_id .':*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:nav:user_submenus:byUserId:'. $user->user_id .':*');

        $this->session->flash('USER_UPDATE_SUCCESS', 'The User has been successfully updated!');
        $this->session->flash('USER_UPDATE_SUCCESS_SLUG', $user->slug);

    }





    public function onDestroy($user){
        
        $this->__cache->deletePattern(''. config('app.name') .'_cache:users:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:users:findBySlug:'. $user->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:users:getByIsOnline:*');
        
        $this->__cache->deletePattern(''. config('app.name') .'_cache:user_menus:getByUserId:'. $user->user_id .':*');

        $this->__cache->deletePattern(''. config('app.name') .'_cache:nav:user_menus:byUserId:'. $user->user_id .':*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:nav:user_submenus:byUserId:'. $user->user_id .':*');

        $this->session->flash('USER_DELETE_SUCCESS', 'User successfully removed!');

    }





    public function onActivate($user){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:users:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:users:findBySlug:'. $user->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:user_menus:getByUserId:'. $user->user_id .':*');

        $this->session->flash('USER_ACTIVATE_SUCCESS', 'User successfully activated!');
        $this->session->flash('USER_ACTIVATE_SUCCESS_SLUG', $user->slug);

    }





    public function onDeactivate($user){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:users:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:users:findBySlug:'. $user->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:user_menus:getByUserId:'. $user->user_id .':*');

        $this->session->flash('USER_DEACTIVATE_SUCCESS', 'User successfully deactivated!');
        $this->session->flash('USER_DEACTIVATE_SUCCESS_SLUG', $user->slug);

    }





    public function onLogout($user){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:users:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:users:findBySlug:'. $user->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:users:getByIsOnline:1');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:user_menus:getByUserId:'. $user->user_id .':*');

        $this->session->flash('USER_LOGOUT_SUCCESS', 'User successfully logout!');
        $this->session->flash('USER_LOGOUT_SUCCESS_SLUG', $user->slug);

    }





    public function onResetPasswordPost($user){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:users:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:users:findBySlug:'. $user->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:user_menus:getByUserId:'. $user->user_id .':*');

        $this->session->flash('USER_RESET_PASSWORD_SUCCESS', 'User password successfully reset!');
        $this->session->flash('USER_RESET_PASSWORD_SUCCESS_SLUG', $user->slug);

    }





    public function onSyncEmployeePost($user, $employee){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:users:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:users:findBySlug:'. $user->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:user_menus:getByUserId:'. $user->user_id .':*');

        $this->__cache->deletePattern(''. config('app.name') .'_cache:employees:findBySlug:'. $employee->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:employees:findByUserId:'. $user->user_id .'');

        $this->session->flash('USER_SYNC_EMPLOYEE_SUCCESS', 'User Successfully Synchronized!');
        $this->session->flash('USER_SYNC_EMPLOYEE_SUCCESS_SLUG', $user->slug);
        
    }





    public function onUnsyncEmployee($user, $employee){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:users:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:users:findBySlug:'. $user->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:user_menus:getByUserId:'. $user->user_id .':*');

        $this->__cache->deletePattern(''. config('app.name') .'_cache:employees:findBySlug:'. $employee->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:employees:findByUserId:'. $user->user_id .'');

        $this->session->flash('USER_UNSYNC_EMPLOYEE_SUCCESS', 'User Successfully Unsynchronized!');
        $this->session->flash('USER_UNSYNC_EMPLOYEE_SUCCESS_SLUG', $user->slug);

    }





}