<?php

namespace App\Http\Controllers;


use App\Core\Services\MenuService;
use App\Http\Requests\Menu\MenuFormRequest;
use App\Http\Requests\Menu\MenuFilterRequest;



class MenuController extends Controller{


    protected $menu;



    public function __construct(MenuService $menu){

        $this->menu = $menu;

    }


    
    public function index(MenuFilterRequest $request){
        
        return $this->menu->fetch($request);

    }

    

    public function create(){
        
        return view('dashboard.menu.create');

    }

   

    public function store(MenuFormRequest $request){
        
        return $this->menu->store($request);

    }
 



    public function edit($slug){
        
        return $this->menu->edit($slug);

    }




    public function update(MenuFormRequest $request, $slug){
        
        return $this->menu->update($request, $slug);

    }

    


    public function destroy($slug){
        
        return $this->menu->destroy($slug);

    }



    
}
