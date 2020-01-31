<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;


use App\Core\Interfaces\SubmenuInterface;
use Illuminate\Http\Request;




class ApiSubmenuController extends Controller{




	protected $submenu_repo;





	public function __construct(SubmenuInterface $submenu_repo){

		$this->submenu_repo = $submenu_repo;

	}






	public function selectSubmenuByMenuId(Request $request, $menu_id){

    	if($request->Ajax()){
    		$response_submenu = $this->submenu_repo->getByMenuId($menu_id);
	    	return json_encode($response_submenu);
	    }

	    return abort(404);

    }






    
}
