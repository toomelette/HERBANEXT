<?php


// Submenu
Route::get('/submenu/select_submenu_byMenuId/{menu_id}', 'Api\ApiSubmenuController@selectSubmenuByMenuId')
		->name('selectSubmenuByMenuId');


// item
Route::get('/item/select_item_byProductCode/{product_code}', 'Api\ApiItemController@selectItemByProductCode')
		->name('selectItemByProductCode');



