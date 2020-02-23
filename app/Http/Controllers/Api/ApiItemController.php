<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Core\Interfaces\ItemInterface;
use Illuminate\Http\Request;

class ApiItemController extends Controller{




	protected $item_repo;





	public function __construct(ItemInterface $item_repo){

		$this->item_repo = $item_repo;

	}





	public function selectItemByProductCode(Request $request, $product_code){

    	if($request->Ajax()){
    		$response_item = $this->item_repo->getByProductCode($product_code);
	    	return json_encode($response_item);
	    }

	    return abort(404);

    }



    
}
