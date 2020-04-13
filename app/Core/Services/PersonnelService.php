<?php
 
namespace App\Core\Services;


use App\Core\Interfaces\PersonnelInterface;
use App\Core\BaseClasses\BaseService;


class PersonnelService extends BaseService{



    protected $personnel_repo;



    public function __construct(PersonnelInterface $personnel_repo){

        $this->personnel_repo = $personnel_repo;
        parent::__construct();

    }



    public function fetch($request){

        $personnels = $this->personnel_repo->fetch($request);
        $request->flash();
        return view('dashboard.personnel.index')->with('personnels', $personnels);

    }



    public function store($request){

        $personnel = $this->personnel_repo->store($request);
        $this->event->fire('personnel.store');
        return redirect()->back();

    }



    public function edit($slug){

        $personnel = $this->personnel_repo->findbySlug($slug);
        return view('dashboard.personnel.edit')->with('personnel', $personnel);

    }



    public function update($request, $slug){

        $personnel = $this->personnel_repo->update($request, $slug);
        $this->event->fire('personnel.update', $personnel);
        return redirect()->route('dashboard.personnel.index');

    }



    public function destroy($slug){

        $personnel = $this->personnel_repo->destroy($slug);
        $this->event->fire('personnel.destroy', $personnel);
        return redirect()->back();

    }




}