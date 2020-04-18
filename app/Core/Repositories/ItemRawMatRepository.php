<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\ItemRawMatInterface;


use App\Models\ItemRawMat;


class ItemRawMatRepository extends BaseRepository implements ItemRawMatInterface {
	



    protected $item_raw_mat;




	public function __construct(ItemRawMat $item_raw_mat){

        $this->item_raw_mat = $item_raw_mat;
        parent::__construct();

    }






    public function store($data, $item, $item_raw_mat_orig){

        $item_raw_mat = new ItemRawMat;
        $item_raw_mat->product_code = $item_raw_mat_orig->product_code;
        $item_raw_mat->item_id = $item->item_id;
        $item_raw_mat->item_raw_mat_id = $this->getItemRawMatIdInc();
        $item_raw_mat->item_raw_mat_item_id = $data['item']; 
        $item_raw_mat->name = $item_raw_mat_orig->name; 
        $item_raw_mat->unit_type_id = $item->unit_type_id; 
        $item_raw_mat->save();
        
        return $item_raw_mat;

    }






    public function getItemRawMatIdInc(){

        $id = 'IRM100001';

        $item_raw_mat = $this->item_raw_mat->select('item_raw_mat_id')->orderBy('item_raw_mat_id', 'desc')->first();

        if($item_raw_mat != null){
            $num = str_replace('IRM', '', $item_raw_mat->item_raw_mat_id) + 1;
            $id = 'IRM' . $num;
        }
        
        return $id;
        
    }







}