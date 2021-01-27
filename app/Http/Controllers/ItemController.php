<?php

namespace App\Http\Controllers;

use App\Core\Services\ItemService;
use App\Http\Requests\Item\ItemFormRequest;
use App\Http\Requests\Item\ItemFilterRequest;
use App\Http\Requests\Item\ItemCheckInFormRequest;
use App\Http\Requests\Item\ItemCheckInExistingBatchFormRequest;
use App\Http\Requests\Item\ItemCheckOutFormRequest;
use App\Http\Requests\Item\ItemCheckOutByBatchFormRequest;
use App\Http\Requests\Item\ItemLogsFilterRequest;
use App\Http\Requests\Item\ItemBatchByItemFilterRequest;
use App\Http\Requests\Item\ItemBatchAddRemarksForm;
use App\Http\Requests\Item\ItemLogsByItemFilterRequest;
use App\Http\Requests\Item\ItemReportFormRequest;
use App\Http\Requests\Item\ItemLogsUpdateRemarksFormRequest;



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

    


    public function checkInExistingBatch($slug){
        
        return $this->item->checkInExistingBatch($slug);

    }

    


    public function checkInExistingBatchPost(ItemCheckInExistingBatchFormRequest $request, $slug){

        return $this->item->checkInExistingBatchPost($request, $slug);

    }

    


    public function checkOut($slug){
        
        return $this->item->checkOut($slug);

    }

    


    public function checkOutPost(ItemCheckOutFormRequest $request, $slug){

        return $this->item->checkOutPost($request, $slug);

    }

    


    public function checkOutByBatch($slug){
        
        return $this->item->checkOutByBatch($slug);

    }

    


    public function checkOutByBatchPost(ItemCheckOutByBatchFormRequest $request, $slug){

        return $this->item->checkOutByBatchPost($request, $slug);

    }

    


    public function logs(ItemLogsFilterRequest $request){

        return $this->item->logs($request);

    }

    


    public function logsUpdateRemarks($id, ItemLogsUpdateRemarksFormRequest $request){
        
        return $this->item->logsUpdateRemarks($id, $request);

    }

    


    public function fetchBatchByItem($slug, ItemBatchByItemFilterRequest $request){

        return $this->item->fetchBatchByItem($slug, $request);

    }

    


    public function batchAddRemarks($batch_id, ItemBatchAddRemarksForm $request){

        return $this->item->batchAddRemarks($batch_id, $request);

    }

    


    public function fetchLogsByItem($slug, ItemLogsByItemFilterRequest $request){

        return $this->item->fetchLogsByItem($slug, $request);

    }




    public function reports(){

        return view('dashboard.item.reports');

    }




    public function reportsOutput(ItemReportFormRequest $request){

        return $this->item->reportsOutput($request);

    }


    


}
