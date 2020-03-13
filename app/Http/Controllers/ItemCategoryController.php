<?php

namespace App\Http\Controllers;

use App\Core\Services\ItemCategoryService;
use App\Http\Requests\ItemCategory\ItemCategoryFormRequest;
use App\Http\Requests\ItemCategory\ItemCategoryFilterRequest;


class ItemCategoryController extends Controller{


	protected $item_category;



    public function __construct(ItemCategoryService $item_category){

        $this->item_category = $item_category;

    }


    
    public function index(ItemCategoryFilterRequest $request){
        
        return $this->item_category->fetch($request);

    }

    

    public function create(){
        
        return view('dashboard.item_category.create');

    }

   

    public function store(ItemCategoryFormRequest $request){
        
        return $this->item_category->store($request);

    }
 



    public function edit($slug){
        
        return $this->item_category->edit($slug);

    }




    public function update(ItemCategoryFormRequest $request, $slug){
        
        return $this->item_category->update($request, $slug);

    }

    


    public function destroy($slug){
        
        return $this->item_category->destroy($slug);

    }


    
}
