<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\UserInterface;

use Hash;
use App\Models\User;


class UserRepository extends BaseRepository implements UserInterface {
	

	protected $user;



	public function __construct(User $user){

        $this->user = $user;

        parent::__construct();

    }






	public function fetch($request){
	
		$key = str_slug($request->fullUrl(), '_');

        $users = $this->cache->remember('users:fetch:' . $key, 240, function() use ($request){

            $user = $this->user->newQuery();
            
            if(isset($request->q)){
                $this->search($user, $request->q);
            }

            if(isset($request->ol)){
                $this->isOnline($user, $this->__dataType->string_to_boolean($request->ol));
            }

            if(isset($request->a)){
                 $this->isActive($user, $this->__dataType->string_to_boolean($request->a));
            }

            return $this->populate($user);

        });

        return $users;
	
	}
	





	public function store($request){

        $user = new User;
        $user->slug = $this->str->random(16);
        $user->user_id = $this->getUserIdInc();
        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->position = $request->position;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->created_at = $this->carbon->now();
        $user->updated_at = $this->carbon->now();
        $user->ip_created = request()->ip();
        $user->ip_updated = request()->ip();
        $user->user_created = $this->auth->user()->user_id;
        $user->user_updated = $this->auth->user()->user_id;
        $user->save();

        return $user;

    }






    public function update($request, $slug){

        $user = $this->findBySlug($slug);
        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->position = $request->position;
        $user->username = $request->username;
        $user->updated_at = $this->carbon->now();
        $user->ip_updated = request()->ip();
        $user->user_updated = $this->auth->user()->user_id;
        $user->save();

        $user->userMenu()->delete();
        $user->userSubmenu()->delete();

        return $user;

    }






    public function destroy($slug){

        $user = $this->findBySlug($slug);  
        $user->delete();
        $user->userMenu()->delete();
        $user->userSubmenu()->delete();

        return $user;

    }






    public function activate($slug){

        $user = $this->findBySlug($slug);
        $user->is_active = 1;
        $user->save();

        return $user;

    }





    public function deactivate($slug){

        $user = $this->findBySlug($slug);
        $user->is_active = 0;
        $user->is_online = 0;
        $user->save();

        return $user;

    }






    public function resetPassword($model, $request){

        $model->password = Hash::make($request->password);
        $model->is_online = 0;
        $model->save();

        return $model;

    }






    public function login($slug){

        $user = $this->findBySlug($slug);

        $user->is_online = 1;
        $user->last_login_time = $this->carbon->now();
        $user->last_login_machine = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $user->last_login_ip = request()->ip();
        $user->save();

        return $user;

    }






    public function logout($slug){

        $user = $this->findBySlug($slug);
        $user->is_online = 0;
        $user->save();

        return $user;

    }






	public function findBySlug($slug){

        $user = $this->cache->remember('users:findBySlug:' . $slug, 240, function() use ($slug){
            return $this->user->where('slug', $slug)->with(['userMenu', 'userMenu.userSubMenu'])->first();
        }); 
        
        if(empty($user)){
            abort(404);
        }

        return $user;

    }






	public function search($model, $key){

        return $model->where(function ($model) use ($key) {
                $model->where('firstname', 'LIKE', '%'. $key .'%')
                      ->orwhere('middlename', 'LIKE', '%'. $key .'%')
                      ->orwhere('lastname', 'LIKE', '%'. $key .'%')
                      ->orwhere('username', 'LIKE', '%'. $key .'%');
        });

    }





    public function isOnline($model, $value){

        return $model->where('is_online', $value);

    }





    public function isActive($model, $value){

        return $model->where('is_active', $value);

    }





    public function populate($model){

        return $model->select('user_id', 'username', 'firstname', 'middlename', 'lastname', 'is_online', 'is_active', 'slug')
                     ->sortable()
                     ->orderBy('updated_at', 'desc')
                     ->paginate(10);

    }





    public function getUserIdInc(){

        $id = 'U10001';

        $user = $this->user->select('user_id')->orderBy('user_id', 'desc')->first();

        if($user != null){

            if($user->user_id != null){
                $num = str_replace('U', '', $user->user_id) + 1;
                $id = 'U' . $num;
            }
        
        }
        
        return $id;
        
    }





    public function getByIsOnline($status){

        $users = $this->cache->remember('users:getByIsOnline:'. $status .'', 240, function() use ($status){
            return $this->user->where('is_online', $status)->get();
        }); 

        return $users;
        
    }
    






}