<?php
 
namespace App\Core\Services;

use Hash;
use App\Core\BaseClasses\BaseService;
use App\Core\Interfaces\ProfileInterface;
use App\Core\Interfaces\UserInterface;

use File;


class ProfileService extends BaseService{



    protected $profile_repo;
    protected $user_repo;



    public function __construct(ProfileInterface $profile_repo, UserInterface $user_repo){

        $this->profile_repo = $profile_repo;
        $this->user_repo = $user_repo;
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




    public function viewAvatar($slug){

        $user = $this->user_repo->findBySlug($slug);

        if(!empty($user->avatar_location)){

            $path = $this->__static->archive_dir() .'/'. $user->avatar_location;

            if (!File::exists($path)) { return "Cannot Detect File!"; }

            $file = File::get($path);
            $type = File::mimeType($path);

            $response = response()->make($file, 200);
            $response->header("Content-Type", $type);

            return $response;

        }

        return "Cannot Detect File!";;
        

    }





}