<?php

namespace App\Http\Controllers;

use App\Core\Services\ItemService;
use App\Http\Requests\Item\ItemFormRequest;
use App\Http\Requests\Item\ItemFilterRequest;
use App\Http\Requests\Item\ItemCheckInFormRequest;
use App\Http\Requests\Item\ItemCheckOutFormRequest;
use App\Http\Requests\Item\ItemLogsFilterRequest;


class ItemController extends Controller{


	protected $item;



    public function __construct(ItemService $item){

        $this->item = $item;

    }


    
    public function index(ItemFilterRequest $request){
        
        return $this->item->fetch($request);

    }

    

    public function create(){
        
        return view('dashboard.item.create');

    }

   

    public function store(ItemFormRequest $request){
        
        return $this->item->store($request);

    }
 



    public function edit($slug){
        
        return $this->item->edit($slug);

    }




    public function update(ItemFormRequest $request, $slug){
        
        return $this->item->update($request, $slug);

    }

    


    public function destroy($slug){
        
        return $this->item->destroy($slug);

    }

    


    public function checkIn($slug){
        
        return $this->item->checkIn($slug);

    }

    


    public function checkInPost(ItemCheckInFormRequest $request, $slug){

        return $this->item->checkInPost($request, $slug);

    }

    


    public function checkOut($slug){
        
        return $this->item->checkOut($slug);

    }

    


    public function checkOutPost(ItemCheckOutFormRequest $request, $slug){

        return $this->item->checkOutPost($request, $slug);

    }

    


    public function logs(ItemLogsFilterRequest $request){

        return $this->item->logs($request);

    }


    


}
