<?php
 
namespace App\Core\Services;


use App\Core\Interfaces\ItemCategoryInterface;
use App\Core\BaseClasses\BaseService;


class ItemCategoryService extends BaseService{


    protected $item_category_repo;



    public function __construct(ItemCategoryInterface $item_category_repo){

        $this->item_category_repo = $item_category_repo;
        parent::__construct();

    }





    public function fetch($request){

        $item_categories = $this->item_category_repo->fetch($request);

        $request->flash();
        return view('dashboard.item_category.index')->with('item_categories', $item_categories);

    }






    public function store($request){

        $item_category = $this->item_category_repo->store($request);
        
        $this->event->fire('item_category.store');
        return redirect()->back();

    }






    public function edit($slug){

        $item_category = $this->item_category_repo->findbySlug($slug);
        return view('dashboard.item_category.edit')->with('item_category', $item_category);

    }






    public function update($request, $slug){

        $item_category = $this->item_category_repo->update($request, $slug);

        $this->event->fire('item_category.update', $item_category);
        return redirect()->route('dashboard.item_category.index');

    }






    public function destroy($slug){

        $item_category = $this->item_category_repo->destroy($slug);

        $this->event->fire('item_category.destroy', $item_category);
        return redirect()->back();

    }






}