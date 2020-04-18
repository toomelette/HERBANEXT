<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\ItemPackMatInterface;


use App\Models\ItemPackMat;


class ItemPackMatRepository extends BaseRepository implements ItemPackMatInterface {
	



    protected $item_pack_mat;




	public function __construct(ItemPackMat $item_pack_mat){

        $this->item_pack_mat = $item_pack_mat;
        parent::__construct();

    }






    public function store($data, $item, $item_pack_mat_orig){

        $item_pack_mat = new ItemPackMat;
        $item_pack_mat->product_code = $item_pack_mat_orig->product_code;
        $item_pack_mat->item_id = $item->item_id;
        $item_pack_mat->item_pack_mat_id = $this->getItemPackMatIdInc();
        $item_pack_mat->item_pack_mat_item_id = $data['item']; 
        $item_pack_mat->name = $item_pack_mat_orig->name; 
        $item_pack_mat->description = $item_pack_mat_orig->description; 
        $item_pack_mat->unit_type_id = $item->unit_type_id; 
        $item_pack_mat->save();
        
        return $item_pack_mat;

    }






    public function getItemPackMatIdInc(){

        $id = 'IPM100001';

        $item_pack_mat = $this->item_pack_mat->select('item_pack_mat_id')->orderBy('item_pack_mat_id', 'desc')->first();

        if($item_pack_mat != null){
            $num = str_replace('IPM', '', $item_pack_mat->item_pack_mat_id) + 1;
            $id = 'IPM' . $num;
        }
        
        return $id;
        
    }







}