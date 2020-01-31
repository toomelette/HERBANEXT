<?php
 
namespace App\Core\Services;

use App\Core\BaseClasses\BaseService;
use App\Core\Interfaces\UserInterface;
use App\Core\Interfaces\UserMenuInterface;
use App\Core\Interfaces\UserSubmenuInterface;
use App\Core\Interfaces\MenuInterface;
use App\Core\Interfaces\SubmenuInterface;

use Hash;

class UserService extends BaseService{


    protected $user_repo;
    protected $user_menu_repo;
    protected $user_submenu_repo;
    protected $menu_repo;
    protected $submenu_repo;



    public function __construct(UserInterface $user_repo, UserMenuInterface $user_menu_repo, UserSubmenuInterface $user_submenu_repo, MenuInterface $menu_repo, SubmenuInterface $submenu_repo){

        $this->user_repo = $user_repo;
        $this->user_menu_repo = $user_menu_repo;
        $this->user_submenu_repo = $user_submenu_repo;
        $this->menu_repo = $menu_repo;
        $this->submenu_repo = $submenu_repo;

        parent::__construct();

    }






    public function fetch($request){

        $users = $this->user_repo->fetch($request);

        $request->flash();
        
        return view('dashboard.user.index')->with('users', $users);

    }






    public function store($request){

        $user = $this->user_repo->store($request);

        if(!empty($request->menu)){

            $count_menu = count($request->menu);

            for($i = 0; $i < $count_menu; $i++){

                $menu = $this->menu_repo->findByMenuId($request->menu[$i]);

                $user_menu = $this->user_menu_repo->store($user, $menu);

                if(!empty($request->submenu)){

                    foreach($request->submenu as $data){

                        $submenu = $this->submenu_repo->findBySubmenuId($data);

                        if($menu->menu_id == $submenu->menu_id){

                            $this->user_submenu_repo->store($submenu, $user_menu);
                        
                        }

                    }

                }

            }

        }

        $this->event->fire('user.store');
        return redirect()->back();

    }






    public function show($slug){
        
        $user = $this->user_repo->findBySlug($slug);  
        return view('dashboard.user.show')->with('user', $user);

    }






    public function edit($slug){

    	$user = $this->user_repo->findBySlug($slug);  
        return view('dashboard.user.edit')->with('user', $user);

    }






    public function update($request, $slug){

        $user = $this->user_repo->update($request, $slug);

        if(!empty($request->menu)){

            $count_menu = count($request->menu);

            for($i = 0; $i < $count_menu; $i++){

                $menu = $this->menu_repo->findByMenuId($request->menu[$i]);

                $user_menu = $this->user_menu_repo->store($user, $menu);

                if(!empty($request->submenu)){

                    foreach($request->submenu as $data){

                        $submenu = $this->submenu_repo->findBySubmenuId($data);

                        if($menu->menu_id === $submenu->menu_id){

                            $this->user_submenu_repo->store($submenu, $user_menu);
                        
                        }

                    }

                }

            }
            
        }

        $this->event->fire('user.update', $user);
        return redirect()->route('dashboard.user.index');

    }






    public function delete($slug){

        $user = $this->user_repo->destroy($slug);

        $this->event->fire('user.destroy', $user);
        return redirect()->back();

    }






    public function activate($slug){

        $user = $this->user_repo->activate($slug);  

        $this->event->fire('user.activate', $user);
        return redirect()->back();

    }






    public function deactivate($slug){

        $user = $this->user_repo->deactivate($slug);  
        
        $this->event->fire('user.deactivate', $user);
        return redirect()->back();

    }






    public function logout($slug){

        $user = $this->user_repo->logout($slug);  

        $this->event->fire('user.logout', $user);
        return redirect()->back();

    }






    public function resetPassword($slug){

        $user = $this->user_repo->findBySlug($slug); 
        return view('dashboard.user.reset_password')->with('user', $user);

    }






    public function resetPasswordPost($request, $slug){

        $user = $this->user_repo->findBySlug($slug);  

        if ($request->username == $this->auth->user()->username && Hash::check($request->user_password, $this->auth->user()->password)) {
            
            if($user->username == $this->auth->user()->username){

                $this->session->flash('USER_RESET_PASSWORD_OWN_ACCOUNT_FAIL', 'Please refer to profile page if you want to reset your own password.');
                return redirect()->back();

            }else{

                $this->user_repo->resetPassword($user, $request);

                $this->event->fire('user.reset_password_post', $user);
                return redirect()->route('dashboard.user.index');

            }
            
        }

        $this->session->flash('USER_RESET_PASSWORD_CONFIRMATION_FAIL', 'The credentials you provided does not match the current user!');
        return redirect()->back();

    }







}