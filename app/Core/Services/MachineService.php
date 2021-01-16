<?php
 
namespace App\Core\Services;


use App\Core\Interfaces\MachineInterface;
use App\Core\BaseClasses\BaseService;


class MachineService extends BaseService{



    protected $machine_repo;



    public function __construct(MachineInterface $machine_repo){

        $this->machine_repo = $machine_repo;
        parent::__construct();

    }



    public function fetch($request){

        $machines = $this->machine_repo->fetch($request);
        $request->flash();
        return view('dashboard.machine.index')->with('machines', $machines);

    }



    public function store($request){

        $machine = $this->machine_repo->store($request);
        $this->event->fire('machine.store');
        return redirect()->back();

    }



    public function edit($slug){

        $machine = $this->machine_repo->findbySlug($slug);
        return view('dashboard.machine.edit')->with('machine', $machine);

    }



    public function update($request, $slug){

        $machine = $this->machine_repo->update($request, $slug);
        $this->event->fire('machine.update', $machine);
        return redirect()->route('dashboard.machine.index');

    }



    public function destroy($slug){

        $machine = $this->machine_repo->destroy($slug);
        $this->event->fire('machine.destroy', $machine);
        return redirect()->back();

    }



    public function updateStatus($request, $slug){

        $machine = $this->machine_repo->updateStatus($request, $slug);
        $this->event->fire('machine.update', $machine);
        return redirect()->back();

    }




}