<?php

namespace App\Http\Controllers;


use App\Core\Services\MachineService;
use App\Http\Requests\Machine\MachineFormRequest;
use App\Http\Requests\Machine\MachineFilterRequest;


class MachineController extends Controller{


    protected $machine;


    public function __construct(MachineService $machine){
        $this->machine = $machine;
    }

    
    public function index(MachineFilterRequest $request){
        return $this->machine->fetch($request);
    }

    
    public function create(){
        return view('dashboard.machine.create');
    }

   
    public function store(MachineFormRequest $request){
        return $this->machine->store($request);
    }
 

    public function edit($slug){
        return $this->machine->edit($slug);
    }


    public function update(MachineFormRequest $request, $slug){
        return $this->machine->update($request, $slug);
    }

    
    public function destroy($slug){
        return $this->machine->destroy($slug);
    }
 

    public function maintenance($slug){
        return $this->machine->maintenance($slug);
    }


}
