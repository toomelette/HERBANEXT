<?php


// Submenu
Route::get('/submenu/select_submenu_byMenuId/{menu_id}', 'Api\ApiSubmenuController@selectSubmenuByMenuId')->name('selectSubmenuByMenuId');

// Item
Route::get('/item/select_item_byItemId/{product_code}', 'Api\ApiItemController@selectItemByItemId')->name('selectItemByItemId');

// Task
Route::post('/task/drop/{slug}', 'Api\ApiTaskController@drop');
Route::post('/task/resize/{slug}', 'Api\ApiTaskController@resize');
Route::post('/task/eventDrop/{slug}', 'Api\ApiTaskController@eventDrop');



