<?php
 
namespace App\Core\Services;


use App\Core\Interfaces\ItemTypeInterface;
use App\Core\BaseClasses\BaseService;


class ItemTypeService extends BaseService{


    protected $item_type_repo;



    public function __construct(ItemTypeInterface $item_type_repo){

        $this->item_type_repo = $item_type_repo;
        parent::__construct();

    }





    public function fetch($request){

        $item_types = $this->item_type_repo->fetch($request);

        $request->flash();
        return view('dashboard.item_type.index')->with('item_types', $item_types);

    }






    public function store($request){

        $item_type = $this->item_type_repo->store($request);
        
        $this->event->fire('item_type.store');
        return redirect()->back();

    }






    public function edit($slug){

        $item_type = $this->item_type_repo->findbySlug($slug);
        return view('dashboard.item_type.edit')->with('item_type', $item_type);

    }






    public function update($request, $slug){

        $item_type = $this->item_type_repo->update($request, $slug);

        $this->event->fire('item_type.update', $item_type);
        return redirect()->route('dashboard.item_type.index');

    }






    public function destroy($slug){

        $item_type = $this->item_type_repo->destroy($slug);

        $this->event->fire('item_type.destroy', $item_type);
        return redirect()->back();

    }






}