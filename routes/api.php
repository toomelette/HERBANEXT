<?php


// Submenu
Route::get('/submenu/select_submenu_byMenuId/{menu_id}', 'Api\ApiSubmenuController@selectSubmenuByMenuId')->name('selectSubmenuByMenuId');

// Item
Route::get('/item/select_item_byItemId/{product_code}', 'Api\ApiItemController@selectItemByItemId')->name('selectItemByItemId');

//Machine Maintenance
Route::get('/machine_maintenance/{slug}/edit', 'Api\ApiMachineMaintenanceController@edit')->name('api.machine_maintenance.edit');



