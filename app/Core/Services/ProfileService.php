<?php
 
namespace App\Core\Services;

use Hash;
use App\Core\BaseClasses\BaseService;
use App\Core\Interfaces\ProfileInterface;


class ProfileService extends BaseService{



    protected $profile_repo;



    public function __construct(ProfileInterface $profile_repo){

        $this->profile_repo = $profile_repo;
        parent::__construct();

    }





    public function updateAccountUsername($request, $slug){

        $user = $this->profile_repo->updateUsername($request, $slug);

        $this->session->flush();
        $this->auth->logout();

        $this->event->fire('profile.update_account_username', $user);
        return redirect('/');

    }






    public function updateAccountPassword($request, $slug){

        if(Hash::check($request->old_password, $this->auth->user()->password)){

            $user = $this->profile_repo->updatePassword($request, $slug);

            $this->session->flush();
            $this->auth->logout();

            $this->event->fire('profile.update_account_password', $user);
            return redirect('/');

        }

        $this->session->flash('PROFILE_OLD_PASSWORD_FAIL', 'The old password you provided does not match.');
        return redirect()->back();

    }






    public function updateAccountColor($request, $slug){

        $user = $this->profile_repo->updateColor($request, $slug);

        $this->event->fire('profile.update_account_color', $user);
        return redirect()->back();

    }





}