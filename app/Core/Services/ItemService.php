<?php
 
namespace App\Core\Services;


use App\Core\Interfaces\ItemInterface;
use App\Core\BaseClasses\BaseService;


class ItemService extends BaseService{


    protected $item_repo;



    public function __construct(ItemInterface $item_repo){

        $this->item_repo = $item_repo;
        parent::__construct();

    }





    public function fetch($request){

        $items = $this->item_repo->fetch($request);

        $request->flash();
        return view('dashboard.item.index')->with('items', $items);

    }






    public function store($request){

        $item = $this->item_repo->store($request);
        
        $this->event->fire('item.store');
        return redirect()->back();

    }






    public function edit($slug){

        $item = $this->item_repo->findbySlug($slug);
        return view('dashboard.item.edit')->with('item', $item);

    }






    public function update($request, $slug){

        $item = $this->item_repo->update($request, $slug);

        $this->event->fire('item.update', $item);
        return redirect()->route('dashboard.item.index');

    }






    public function destroy($slug){

        $item = $this->item_repo->destroy($slug);

        $this->event->fire('item.destroy', $item);
        return redirect()->back();

    }






    public function checkInPost($request, $slug){

        dd($request);

        $this->event->fire('item.check_in', $item);
        return redirect()->back();

    }






}