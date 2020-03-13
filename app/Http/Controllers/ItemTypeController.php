<?php

namespace App\Http\Controllers;

use App\Core\Services\ItemTypeService;
use App\Http\Requests\ItemType\ItemTypeFormRequest;
use App\Http\Requests\ItemType\ItemTypeFilterRequest;

class ItemTypeController extends Controller{


	protected $item_type;



    public function __construct(ItemTypeService $item_type){

        $this->item_type = $item_type;

    }


    
    public function index(ItemTypeFilterRequest $request){
        
        return $this->item_type->fetch($request);

    }

    

    public function create(){
        
        return view('dashboard.item_type.create');

    }

   

    public function store(ItemTypeFormRequest $request){
        
        return $this->item_type->store($request);

    }
 



    public function edit($slug){
        
        return $this->item_type->edit($slug);

    }




    public function update(ItemTypeFormRequest $request, $slug){
        
        return $this->item_type->update($request, $slug);

    }

    


    public function destroy($slug){
        
        return $this->item_type->destroy($slug);

    }



    
}
