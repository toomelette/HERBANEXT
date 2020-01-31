<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Services\UserService;
use App\Http\Requests\User\UserFormRequest;
use App\Http\Requests\User\UserFilterRequest;
use App\Http\Requests\User\UserResetPasswordRequest;
use App\Http\Requests\User\UserSyncEmployeeRequest;


class UserController extends Controller{

       

    protected $user_service; 



    public function __construct(UserService $user_service){

        $this->user_service = $user_service;

    }




    public function index(UserFilterRequest $request){

        return $this->user_service->fetch($request);

    }

    


    public function create(){

        return view('dashboard.user.create');

    }

    


    public function store(UserFormRequest $request){

        return $this->user_service->store($request);

    }

    


    public function show($slug){

        return $this->user_service->show($slug);

    }

    


    public function edit($slug){

        return $this->user_service->edit($slug);

    }

    


    public function update(UserFormRequest $request, $slug){

        return $this->user_service->update($request, $slug);
        
    }

    


    public function destroy($slug){

        return $this->user_service->delete($slug);
        
    }




    public function activate($slug){

        return $this->user_service->activate($slug);
        
    }




    public function deactivate($slug){

        return $this->user_service->deactivate($slug);
        
    }




    public function logout($slug){

        return $this->user_service->logout($slug);
        
    }




    public function resetPassword($slug){

        return $this->user_service->resetPassword($slug);
        
    }




    public function resetPasswordPost(UserResetPasswordRequest $request, $slug){

        return $this->user_service->resetPasswordPost($request, $slug);
        
    }




    public function syncEmployee($slug){

        return $this->user_service->syncEmployee($slug);
        
    }




    public function syncEmployeePost(UserSyncEmployeeRequest $request, $slug){

        return $this->user_service->syncEmployeePost($request, $slug);
        
    }




    public function unsyncEmployee($slug){

        return $this->user_service->unsyncEmployee($slug);
        
    }




}
