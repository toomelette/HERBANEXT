<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\ManufacturingOrderRawMatInterface;

use App\Models\ManufacturingOrderRawMat;


class ManufacturingOrderRawMatRawMatRepository extends BaseRepository implements ManufacturingOrderRawMatInterface {
	



    protected $mo_raw_mat;




	public function __construct(ManufacturingOrderRawMat $mo_raw_mat){

        $this->mo_raw_mat = $mo_raw_mat;
        parent::__construct();

    }







}