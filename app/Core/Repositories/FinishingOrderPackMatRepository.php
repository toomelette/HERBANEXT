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



    public function store($mo, $item_pack_mat){

        $fo_pack_mat = new FinishingOrderPackMat;
        $fo_pack_mat->fo_pack_mat_id = $this->getFOPMId();
        $fo_pack_mat->jo_id = $mo->jo_id;
        $fo_pack_mat->fo_id = $mo->fo_id;
        $fo_pack_mat->item_product_code = $item_pack_mat->product_code;
        $fo_pack_mat->item_name = $item_pack_mat->name;
        $fo_pack_mat->item_description = $item_pack_mat->description;
        $fo_pack_mat->unit_type_id = $item_pack_mat->unit_type_id;
        $fo_pack_mat->save();

    }



    public function update($data){

        $fo_pack_mat = $this->findFoPackMatId($data['fo_pack_mat_id']);
        $fo_pack_mat->req_qty = $this->__dataType->string_to_num($data['req_qty']);
        $fo_pack_mat->req_qty_unit = $data['req_qty_unit'];
        $fo_pack_mat->qty_issued = $this->__dataType->string_to_num($data['qty_issued']);
        $fo_pack_mat->qty_issued_unit = $data['qty_issued_unit'];
        $fo_pack_mat->save();

        return $fo_pack_mat; 

    }



    public function updateFigures($data){

        $fo_pack_mat = $this->findFoPackMatId($data['fo_pack_mat_id']);
        $fo_pack_mat->figure_unit = $this->__dataType->string_to_num($data['figure_unit']);
        $fo_pack_mat->figure_actual_usage = $this->__dataType->string_to_num($data['figure_actual_usage']);
        $fo_pack_mat->figure_regected = $this->__dataType->string_to_num($data['figure_regected']);
        $fo_pack_mat->figure_damaged = $this->__dataType->string_to_num($data['figure_damaged']);
        $fo_pack_mat->figure_returns = $this->__dataType->string_to_num($data['figure_returns']);
        $fo_pack_mat->figure_samples = $this->__dataType->string_to_num($data['figure_samples']);
        $fo_pack_mat->figure_total = $this->__dataType->string_to_num($data['figure_total']);
        $fo_pack_mat->figure_difference = $this->__dataType->string_to_num($data['figure_difference']);
        $fo_pack_mat->save();

        return $fo_pack_mat; 

    }



    public function findFoPackMatId($fo_pack_mat_id){

        $fo_pack_mat = $this->fo_pack_mat->where('fo_pack_mat_id', $fo_pack_mat_id)->first();
        if(empty($fo_pack_mat)){abort(404);}
        return $fo_pack_mat;

    }



    public function getFOPMId(){

        $id = 'FOPM100001';
        $fo_pack_mat = $this->fo_pack_mat->select('fo_pack_mat_id')->orderBy('fo_pack_mat_id', 'desc')->first();

        if($fo_pack_mat != null){
            $num = str_replace('FOPM', '', $fo_pack_mat->fo_pack_mat_id) + 1;
            $id = 'FOPM' . $num;
        }
        
        return $id;
        
    }



}