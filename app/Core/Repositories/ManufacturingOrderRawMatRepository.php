<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\ManufacturingOrderRawMatInterface;

use App\Models\ManufacturingOrderRawMat;


class ManufacturingOrderRawMatRepository extends BaseRepository implements ManufacturingOrderRawMatInterface {
	


    protected $mo_raw_mat;



	public function __construct(ManufacturingOrderRawMat $mo_raw_mat){

        $this->mo_raw_mat = $mo_raw_mat;
        parent::__construct();

    }



    public function store($mo, $item_raw_mat){

        $mo_raw_mat = new ManufacturingOrderRawMat;
        $mo_raw_mat->mo_raw_mat_id = $this->getMORMId();
        $mo_raw_mat->jo_id = $mo->jo_id;
        $mo_raw_mat->mo_id = $mo->mo_id;
        $mo_raw_mat->item_product_code = $item_raw_mat->product_code;
        $mo_raw_mat->item_name = $item_raw_mat->name;
        $mo_raw_mat->unit_type_id = $item_raw_mat->unit_type_id;
        $mo_raw_mat->save();

    }



    public function update($data){

        $mo_raw_mat = $this->findByMORawMatId($data['mo_raw_mat_id']);
        $mo_raw_mat->req_qty = $this->__dataType->string_to_num($data['req_qty']);
        $mo_raw_mat->req_qty_unit = $data['req_qty_unit'];
        if (isset($data['req_qty_is_included']) && $data['req_qty_is_included'] == 'true') {
            $mo_raw_mat->req_qty_is_included = true;
        }else{
            $mo_raw_mat->req_qty_is_included = false;
        }
        $mo_raw_mat->batch_no = $data['batch_no'];
        $mo_raw_mat->weighed_by = $data['weighed_by'];
        $mo_raw_mat->save();

        return $mo_raw_mat; 

    }



    public function findByMORawMatId($mo_raw_mat_id){

        $mo_raw_mat = $this->mo_raw_mat->where('mo_raw_mat_id', $mo_raw_mat_id)->first();
        if(empty($mo_raw_mat)){abort(404);}
        return $mo_raw_mat;

    }



    public function getMORMId(){

        $id = 'MORM100001';
        $mo_raw_mat = $this->mo_raw_mat->select('mo_raw_mat_id')->orderBy('mo_raw_mat_id', 'desc')->first();

        if($mo_raw_mat != null){
            $num = str_replace('MORM', '', $mo_raw_mat->mo_raw_mat_id) + 1;
            $id = 'MORM' . $num;
        }
        
        return $id;
        
    }



}