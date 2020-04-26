<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\DeliveryInterface;

use App\Models\Delivery;


class DeliveryRepository extends BaseRepository implements DeliveryInterface {
    


    protected $delivery;



    public function __construct(Delivery $delivery){

        $this->delivery = $delivery;
        parent::__construct();

    }





    public function fetch($request){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $deliveries = $this->cache->remember('deliveries:fetch:' . $key, 240, function() use ($request, $entries){

            $delivery = $this->delivery->newQuery();
            
            if(isset($request->q)){
                $this->search($delivery, $request->q);
            }

            return $this->populate($delivery, $entries);

        });

        return $deliveries;

    }





    public function store($request){

        $delivery = new Delivery;
        $delivery->delivery_id = $this->getDeliveryIdInc();
        $delivery->slug = $this->str->random(16);
        $delivery->delivery_code = $request->delivery_code;
        $delivery->description = $request->description;
        $delivery->date = $this->__dataType::date_parse($request->date);
        $delivery->created_at = $this->carbon->now();
        $delivery->updated_at = $this->carbon->now();
        $delivery->ip_created = request()->ip();
        $delivery->ip_updated = request()->ip();
        $delivery->user_created = $this->auth->user()->user_id;
        $delivery->user_updated = $this->auth->user()->user_id;
        $delivery->save();
        
        return $delivery;

    }





    public function update($request, $slug){

        $delivery = $this->findBySlug($slug);
        $delivery->delivery_code = $request->delivery_code;
        $delivery->description = $request->description;
        $delivery->date = $this->__dataType::date_parse($request->date);
        $delivery->updated_at = $this->carbon->now();
        $delivery->ip_updated = request()->ip();
        $delivery->user_updated = $this->auth->user()->user_id;
        $delivery->save();
        $delivery->deliveryJobOrder()->delete();
        
        return $delivery;

    }





    public function destroy($slug){

        $delivery = $this->findBySlug($slug);
        $delivery->delete();
        $delivery->deliveryJobOrder()->delete();
        return $delivery;

    }





    public function findBySlug($slug){

        $delivery = $this->cache->remember('deliveries:findBySlug:' . $slug, 240, function() use ($slug){
            return $this->delivery->where('slug', $slug)->first();
        }); 
        
        if(empty($delivery)){
            abort(404);
        }

        return $delivery;

    }






    public function search($model, $key){

        return $model->where('delivery_code', 'LIKE', '%'. $key .'%')
                     ->orWhere('description', 'LIKE', '%'. $key .'%');

    }





    public function populate($model, $entries){

        return $model->select('delivery_code', 'description', 'date', 'updated_at', 'slug')
                     ->sortable()
                     ->orderBy('updated_at', 'desc')
                     ->paginate($entries);
    
    }






    public function getDeliveryIdInc(){

        $id = 'D10001';
        $delivery = $this->delivery->select('delivery_id')->orderBy('delivery_id', 'desc')->first();

        if($delivery != null){
            if($delivery->delivery_id != null){
                $num = str_replace('D', '', $delivery->delivery_id) + 1;
                $id = 'D' . $num;
            }
        }
        
        return $id;
        
    }






}