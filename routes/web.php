<?php


/** Auth **/
Route::group(['as' => 'auth.'], function () {
	
	Route::get('/', 'Auth\LoginController@showLoginForm')->name('showLogin');
	Route::post('/', 'Auth\LoginController@login')->name('login');
	Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
	Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

});




/** Dashboard **/
Route::group(['prefix'=>'dashboard', 'as' => 'dashboard.', 'middleware' => ['check.user_status', 'check.user_route']], function () {


	/** HOME **/	
	Route::get('/home', 'HomeController@index')->name('home');


	/** USER **/   
	Route::post('/user/activate/{slug}', 'UserController@activate')->name('user.activate');
	Route::post('/user/deactivate/{slug}', 'UserController@deactivate')->name('user.deactivate');
	Route::post('/user/logout/{slug}', 'UserController@logout')->name('user.logout');
	Route::get('/user/{slug}/reset_password', 'UserController@resetPassword')->name('user.reset_password');
	Route::patch('/user/reset_password/{slug}', 'UserController@resetPasswordPost')->name('user.reset_password_post');
	Route::resource('user', 'UserController');


	/** PROFILE **/
	Route::get('/profile', 'ProfileController@details')->name('profile.details');
	Route::patch('/profile/update_account_username/{slug}', 'ProfileController@updateAccountUsername')->name('profile.update_account_username');
	Route::patch('/profile/update_account_password/{slug}', 'ProfileController@updateAccountPassword')->name('profile.update_account_password');
	Route::patch('/profile/update_account_color/{slug}', 'ProfileController@updateAccountColor')->name('profile.update_account_color');


	/** MENU **/
	Route::resource('menu', 'MenuController');


	/** ITEMS **/	
	Route::get('/item/check_in/{slug}', 'ItemController@checkIn')->name('item.check_in');
	Route::post('/item/check_in/{slug}', 'ItemController@checkInPost')->name('item.check_in_post');
	Route::get('/item/check_in_existing_batch/{slug}', 'ItemController@checkInExistingBatch')
	->name('item.check_in_existing_batch');
	Route::post('/item/check_in_existing_batch/{slug}', 'ItemController@checkInExistingBatchPost')
	->name('item.check_in_existing_batch_post');

	Route::get('/item/check_out/{slug}', 'ItemController@checkOut')->name('item.check_out');
	Route::post('/item/check_out/{slug}', 'ItemController@checkOutPost')->name('item.check_out_post');
	Route::get('/item/check_out_by_batch/{slug}', 'ItemController@checkOutByBatch')->name('item.check_out_by_batch');
	Route::post('/item/check_out_by_batch/{slug}', 'ItemController@checkOutByBatchPost')->name('item.check_out_by_batch_post');

	Route::get('/item/{slug}/batches', 'ItemController@fetchBatchByItem')->name('item.fetch_batch_by_item');
	Route::get('/item/{slug}/logs', 'ItemController@fetchLogsByItem')->name('item.fetch_logs_by_item');
	Route::get('/item/logs', 'ItemController@logs')->name('item.logs');
	Route::resource('item', 'ItemController');


	/** ITEMS CATEGORY **/
	Route::resource('item_category', 'ItemCategoryController');


	/** ITEMS TYPES **/
	Route::resource('item_type', 'ItemTypeController');


	/** PURCHASE ORDER **/
	Route::get('/purchase_order/print/{slug}', 'PurchaseOrderController@print')->name('purchase_order.print');
	Route::get('/purchase_order/buffers/', 'PurchaseOrderController@buffer')->name('purchase_order.buffer');
	Route::post('/purchase_order/to_process/{slug}', 'PurchaseOrderController@toProcess')->name('purchase_order.to_process');
	Route::post('/purchase_order/to_buffer/{slug}', 'PurchaseOrderController@toBuffer')->name('purchase_order.to_buffer');
	Route::resource('purchase_order', 'PurchaseOrderController');


	/** JOB ORDER **/
	Route::post('/job_order/generate/{slug}', 'JobOrderController@generate')->name('job_order.generate');
	Route::get('/job_order/generate_fill/{slug}', 'JobOrderController@generateFill')->name('job_order.generate_fill');
	Route::post('/job_order/generate_fill/{slug}', 'JobOrderController@generateFillPost')->name('job_order.generate_fill_post');
	Route::get('/job_order/print/{slug}', 'JobOrderController@print')->name('job_order.print');
	Route::post('/job_order/confirm_rfd/{status}/{slug}', 'JobOrderController@confirmRFD')->name('job_order.confirm_rfd');
	Route::resource('job_order', 'JobOrderController');


	/** PERSONNELS **/
	Route::resource('personnel', 'PersonnelController');


	/** MACHINES **/
	Route::resource('machine', 'MachineController');


	/** TASKS **/
	Route::get('/task/scheduling', 'TaskController@scheduling')->name('task.scheduling');
	Route::get('/task/calendar', 'TaskController@calendar')->name('task.calendar');
	Route::post('/task/update_finished/{slug}', 'TaskController@updateFinished')
	->name('task.update_finished');
	Route::post('/task/update_unfinished/{slug}', 'TaskController@updateUnfinished')
	->name('task.update_unfinished');
	Route::get('/task/rate_personnel/{task_slug}', 'TaskController@ratePersonnel')
	->name('task.rate_personnel');
	Route::post('/task/rate_personnel/{task_personnel_id}', 'TaskController@ratePersonnelPost')
	->name('task.rate_personnel_post');
	Route::resource('task', 'TaskController');


	/** Delivery **/
	Route::get('/delivery/print/{slug}', 'DeliveryController@print')->name('delivery.print');
	Route::get('/delivery/confirm_delivery/{slug}', 'DeliveryController@confirmDelivery')->name('delivery.confirm_delivery');
	Route::post('/delivery/confirm_delivered_post/{type}/{id}', 'DeliveryController@confirmDeliveredPost')
	->name('delivery.confirm_delivered_post');
	Route::post('/delivery/confirm_returned_post/{type}/{id}', 'DeliveryController@confirmReturnedPost')
	->name('delivery.confirm_returned_post');
	Route::resource('delivery', 'DeliveryController');


	/** Suppliers **/
	Route::resource('supplier', 'SupplierController');


	/** ENGR TASKS **/
	Route::get('/engr_task/create_jo', 'EngrTaskController@createJO')->name('engr_task.create_jo');
	Route::get('/engr_task/create_da', 'EngrTaskController@createDA')->name('engr_task.create_da');
	Route::resource('engr_task', 'EngrTaskController');
	
});






/** Testing **/
// Route::get('/dashboard/test', function(){

// 	return dd(Illuminate\Support\Str::random(16));

// });

