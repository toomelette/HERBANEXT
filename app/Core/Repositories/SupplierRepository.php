<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\SupplierInterface;

use App\Models\Supplier;


class SupplierRepository extends BaseRepository implements SupplierInterface {
	


    protected $supplier;



	public function __construct(Supplier $supplier){

        $this->supplier = $supplier;
        parent::__construct();

    }





    public function fetch($request){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $suppliers = $this->cache->remember('suppliers:fetch:' . $key, 240, function() use ($request, $entries){

            $supplier = $this->supplier->newQuery();
            
            if(isset($request->q)){
                $this->search($supplier, $request->q);
            }

            return $this->populate($supplier, $entries);

        });

        return $suppliers;

    }





    public function store($request){

        $supplier = new Supplier;
        $supplier->supplier_id = $this->getSupplierIdInc();
        $supplier->slug = $this->str->random(16);
        $supplier->name = $request->name;
        $supplier->description = $request->description;
        $supplier->address = $request->address;
        $supplier->contact_email = $request->contact_email;
        $supplier->contact_person = $request->contact_person;
        $supplier->created_at = $this->carbon->now();
        $supplier->updated_at = $this->carbon->now();
        $supplier->ip_created = request()->ip();
        $supplier->ip_updated = request()->ip();
        $supplier->user_created = $this->auth->user()->user_id;
        $supplier->user_updated = $this->auth->user()->user_id;
        $supplier->save();
        
        return $supplier;

    }





    public function update($request, $slug){

        $supplier = $this->findBySlug($slug);
        $supplier->name = $request->name;
        $supplier->description = $request->description;
        $supplier->address = $request->address;
        $supplier->contact_email = $request->contact_email;
        $supplier->contact_person = $request->contact_person;
        $supplier->updated_at = $this->carbon->now();
        $supplier->ip_updated = request()->ip();
        $supplier->user_updated = $this->auth->user()->user_id;
        $supplier->save();
        
        return $supplier;

    }





    public function destroy($slug){

        $supplier = $this->findBySlug($slug);
        $supplier->delete();
        return $supplier;

    }





    public function findBySlug($slug){

        $supplier = $this->cache->remember('suppliers:findBySlug:' . $slug, 240, function() use ($slug){
            return $this->supplier->where('slug', $slug)->first();
        }); 
        
        if(empty($supplier)){
            abort(404);
        }

        return $supplier;

    }






    public function search($model, $key){

        return $model->where(function ($model) use ($key) {
                $model->where('name', 'LIKE', '%'. $key .'%')
                      ->orWhere('description', 'LIKE', '%'. $key .'%')
                      ->orWhere('address', 'LIKE', '%'. $key .'%')
                      ->orWhere('contact_email', 'LIKE', '%'. $key .'%')
                      ->orWhere('contact_person', 'LIKE', '%'. $key .'%');
        });

    }





    public function populate($model, $entries){

        return $model->select('name', 'description', 'address', 'contact_email', 'contact_person', 'slug')
                     ->sortable()
                     ->orderBy('updated_at', 'desc')
                     ->paginate($entries);
    
    }






    public function getSupplierIdInc(){

        $id = 'S10001';
        $supplier = $this->supplier->select('supplier_id')->orderBy('supplier_id', 'desc')->first();

        if($supplier != null){
            if($supplier->supplier_id != null){
                $num = str_replace('S', '', $supplier->supplier_id) + 1;
                $id = 'S' . $num;
            }
        }
        
        return $id;
        
    }






    public function getAll(){

        $suppliers = $this->cache->remember('suppliers:getAll', 240, function(){
            return $this->supplier->select('supplier_id', 'name')
                                   ->get();
        });
        
        return $suppliers;

    }






}