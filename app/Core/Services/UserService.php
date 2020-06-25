<?php
 
namespace App\Core\Services;

use App\Core\BaseClasses\BaseService;
use App\Core\Interfaces\UserInterface;
use App\Core\Interfaces\UserMenuInterface;
use App\Core\Interfaces\UserSubmenuInterface;
use App\Core\Interfaces\MenuInterface;
use App\Core\Interfaces\SubmenuInterface;

use Hash;
use File;

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

        $img_location = "";

        if(!is_null($request->file('avatar'))){
            $filename = $this->__dataType::fileFilterReservedChar($request->username .'-'. $this->str->random(8), '.jpg');
            $request->file('avatar')->storeAs('USERS', $filename);
            $img_location = 'USERS/'. $filename;
        }

        $user = $this->user_repo->store($request, $img_location);

        if(!empty($request->menu)){

            foreach($request->menu as $data_menu){

                $menu = $this->menu_repo->findByMenuId($data_menu);

                $user_menu = $this->user_menu_repo->store($user, $menu);

                if(!empty($request->submenu)){

                    foreach($request->submenu as $data_submenu){

                        $submenu = $this->submenu_repo->findBySubmenuId($data_submenu);

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

        $user = $this->user_repo->findbySlug($slug);
        
        $new_filename = $this->__dataType::fileFilterReservedChar($request->username .'-'. $this->str->random(8), '.jpg');
        $old_file_location = $user->avatar_location;
        $new_file_location = 'USERS/'. $new_filename;

        $img_location = $old_file_location;

        // if img_file has value
        if(!is_null($request->file('avatar'))){

            if ($this->storage->disk('local')->exists($old_file_location)) {
                $this->storage->disk('local')->delete($old_file_location);
            }
            
            $request->file('avatar')->storeAs('USERS', $new_filename);
            $img_location = $new_file_location;

        // if username has change
        }elseif($request->username != $user->username && $this->storage->disk('local')->exists($old_file_location)){
            $this->storage->disk('local')->move($old_file_location, $new_file_location);
            $img_location = $new_file_location;
        }

        $user = $this->user_repo->update($request, $slug, $img_location);

        if(!empty($request->menu)){

            foreach($request->menu as $data_menu){

                $menu = $this->menu_repo->findByMenuId($data_menu);

                $user_menu = $this->user_menu_repo->store($user, $menu);

                if(!empty($request->submenu)){

                    foreach($request->submenu as $data_submenu){

                        $submenu = $this->submenu_repo->findBySubmenuId($data_submenu);

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

        $user = $this->user_repo->findbySlug($slug);

        if(!is_null($user->avatar_location)){
            if ($this->storage->disk('local')->exists($user->avatar_location)) {
                $this->storage->disk('local')->delete($user->avatar_location);
            }
        }

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