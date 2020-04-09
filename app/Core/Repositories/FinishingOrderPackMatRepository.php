<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\FinishingOrderPackMatInterface;

use App\Models\FinishingOrderPackMat;


class FinishingOrderPackMatRepository extends BaseRepository implements FinishingOrderPackMatInterface {
	


    protected $fo_pack_mat;



	public function __construct(FinishingOrderPackMat $fo_pack_mat){

        $this->fo_pack_mat = $fo_pack_mat;
        parent::__construct();

    }



    // public function store($mo, $item_raw_mat){

    //     $fo_pack_mat = new FinishingOrderPackMat;
    //     $fo_pack_mat->fo_pack_mat_id = $this->getMORMId();
    //     $fo_pack_mat->jo_id = $mo->jo_id;
    //     $fo_pack_mat->mo_id = $mo->mo_id;
    //     $fo_pack_mat->item_product_code = $item_raw_mat->product_code;
    //     $fo_pack_mat->item_name = $item_raw_mat->name;
    //     $fo_pack_mat->unit_type_id = $item_raw_mat->unit_type_id;
    //     $fo_pack_mat->save();

    // }



    // public function update($data){

    //     $fo_pack_mat = $this->findByMORawMatId($data['fo_pack_mat_id']);
    //     $fo_pack_mat->req_qty = $this->__dataType->string_to_num($data['req_qty']);
    //     $fo_pack_mat->req_qty_unit = $data['req_qty_unit'];
    //     if (isset($data['req_qty_is_included']) && $data['req_qty_is_included'] == 'true') {
    //         $fo_pack_mat->req_qty_is_included = $this->__dataType->string_to_boolean($data['req_qty_is_included']);
    //     }
    //     $fo_pack_mat->batch_no = $data['batch_no'];
    //     $fo_pack_mat->weighed_by = $data['weighed_by'];
    //     $fo_pack_mat->save();

    //     return $fo_pack_mat; 

    // }



    // public function findByMORawMatId($fo_pack_mat_id){

    //     $fo_pack_mat = $this->fo_pack_mat->where('fo_pack_mat_id', $fo_pack_mat_id)->first();
    //     if(empty($fo_pack_mat)){abort(404);}
    //     return $fo_pack_mat;

    // }



    // public function getMORMId(){

    //     $id = 'FOPM100001';
    //     $fo_pack_mat = $this->fo_pack_mat->select('fo_pack_mat_id')->orderBy('fo_pack_mat_id', 'desc')->first();

    //     if($fo_pack_mat != null){
    //         $num = str_replace('FOPM', '', $fo_pack_mat->fo_pack_mat_id) + 1;
    //         $id = 'FOPM' . $num;
    //     }
        
    //     return $id;
        
    // }



}