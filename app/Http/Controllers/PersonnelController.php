<?php

namespace App\Http\Controllers;


use App\Core\Services\PersonnelService;
use App\Http\Requests\Personnel\PersonnelFormRequest;
use App\Http\Requests\Personnel\PersonnelFilterRequest;


class PersonnelController extends Controller{


    protected $personnel;


    public function __construct(PersonnelService $personnel){
        $this->personnel = $personnel;
    }

    
    public function index(PersonnelFilterRequest $request){
        return $this->personnel->fetch($request);
    }

    
    public function create(){
        return view('dashboard.personnel.create');
    }

   
    public function store(PersonnelFormRequest $request){
        return $this->personnel->store($request);
    }
 

    public function edit($slug){
        return $this->personnel->edit($slug);
    }


    public function update(PersonnelFormRequest $request, $slug){
        return $this->personnel->update($request, $slug);
    }

    
    public function destroy($slug){
        return $this->personnel->destroy($slug);
    }

    
    public function viewAvatar($slug){
        return $this->personnel->viewAvatar($slug);
    }



    
}
