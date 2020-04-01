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
        $mo_raw_mat->save();

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