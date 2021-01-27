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
	Route::patch('/user/reset_password/{slug}', 'UserController@resetPasswordPost')
		 ->name('user.reset_password_post');
	Route::get('/user/view_avatar/{slug}', 'UserController@viewAvatar')
		 ->name('user.view_avatar');
	Route::resource('user', 'UserController');


	/** PROFILE **/
	Route::get('/profile', 'ProfileController@details')->name('profile.details');
	Route::patch('/profile/update_account_username/{slug}', 'ProfileController@updateAccountUsername')->name('profile.update_account_username');
	Route::patch('/profile/update_account_password/{slug}', 'ProfileController@updateAccountPassword')->name('profile.update_account_password');
	Route::patch('/profile/update_account_color/{slug}', 'ProfileController@updateAccountColor')->name('profile.update_account_color');
	Route::get('/profile/view_avatar/{slug}', 'ProfileController@viewAvatar')->name('profile.view_avatar');


	/** MENU **/
	Route::resource('menu', 'MenuController');


	/** ITEMS **/	
	Route::get('/item/check_in/{slug}', 'ItemController@checkIn')->name('item.check_in');
	Route::post('/item/check_in/{slug}', 'ItemController@checkInPost')->name('item.check_in_post');
	Route::get('/item/check_in_existing_batch/{slug}', 'ItemController@checkInExistingBatch')->name('item.check_in_existing_batch');
	Route::post('/item/check_in_existing_batch/{slug}', 'ItemController@checkInExistingBatchPost')->name('item.check_in_existing_batch_post');
	Route::post('/item/batch_add_remarks/{batch_id}', 'ItemController@batchAddRemarks')->name('item.batch_add_remarks');

	Route::get('/item/check_out/{slug}', 'ItemController@checkOut')->name('item.check_out');
	Route::post('/item/check_out/{slug}', 'ItemController@checkOutPost')->name('item.check_out_post');
	Route::get('/item/check_out_by_batch/{slug}', 'ItemController@checkOutByBatch')->name('item.check_out_by_batch');
	Route::post('/item/check_out_by_batch/{slug}', 'ItemController@checkOutByBatchPost')->name('item.check_out_by_batch_post');

	Route::get('/item/{slug}/batches', 'ItemController@fetchBatchByItem')->name('item.fetch_batch_by_item');
	Route::get('/item/{slug}/logs', 'ItemController@fetchLogsByItem')->name('item.fetch_logs_by_item');
	Route::post('/item/logs/update_remarks/{slug}', 'ItemController@logsUpdateRemarks')->name('item.logs_update_remarks');
	Route::get('/item/logs', 'ItemController@logs')->name('item.logs');

	Route::get('/item/reports', 'ItemController@reports')->name('item.reports');
	Route::get('/item/reports_output', 'ItemController@reportsOutput')->name('item.reports_output');
	
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
	Route::get('/personnel/view_avatar/{slug}', 'PersonnelController@viewAvatar')
		 ->name('personnel.view_avatar');
	Route::resource('personnel', 'PersonnelController');


	/** MACHINES **/
	Route::get('/machine/maintenance', 'MachineMaintenanceController@index')->name('machine.maintenance_index');
	Route::post('/machine/maintenance/store', 'MachineMaintenanceController@store')->name('machine.maintenance_store');
	Route::post('/machine/maintenance/update/{slug}', 'MachineMaintenanceController@update')->name('machine.maintenance_update');
	Route::delete('/machine/maintenance/delete/{slug}', 'MachineMaintenanceController@delete')->name('machine.maintenance_delete');
	Route::get('/machine/maintenance/calendar', 'MachineMaintenanceController@calendar')->name('machine.maintenance_calendar');
	Route::post('/machine/update_status/{slug}', 'MachineController@updateStatus')->name('machine.update_status');
	Route::resource('machine', 'MachineController');


	/** TASKS **/
	Route::get('/task/calendar', 'TaskController@calendar')->name('task.calendar');
	Route::post('/task/update_finished/{slug}', 'TaskController@updateFinished')->name('task.update_finished');
	Route::post('/task/update_unfinished/{slug}', 'TaskController@updateUnfinished')->name('task.update_unfinished');
	Route::get('/task/rate_personnel/{task_slug}', 'TaskController@ratePersonnel')->name('task.rate_personnel');
	Route::post('/task/rate_personnel/{task_personnel_id}', 'TaskController@ratePersonnelPost')->name('task.rate_personnel_post');
	Route::get('/task/reports', 'TaskController@reports')->name('task.reports');
	Route::get('/task/reports_output', 'TaskController@reportsOutput')->name('task.reports_output');
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
	Route::post('/engr_task/update_finished/{slug}', 'EngrTaskController@updateFinished')
	->name('engr_task.update_finished');
	Route::post('/engr_task/update_unfinished/{slug}', 'EngrTaskController@updateUnfinished')
	->name('engr_task.update_unfinished');
	Route::get('/engr_task/rate_personnel/{task_slug}', 'EngrTaskController@ratePersonnel')
	->name('engr_task.rate_personnel');
	Route::post('/engr_task/rate_personnel/{task_personnel_id}', 'EngrTaskController@ratePersonnelPost')
	->name('engr_task.rate_personnel_post');
	Route::get('/engr_task/calendar', 'EngrTaskController@calendar')->name('engr_task.calendar');
	Route::get('/engr_task/create_jo', 'EngrTaskController@createJO')->name('engr_task.create_jo');
	Route::get('/engr_task/create_da', 'EngrTaskController@createDA')->name('engr_task.create_da');
	Route::resource('engr_task', 'EngrTaskController');
	
});






/** Testing **/
// Route::get('/dashboard/test', function(){

// 	return dd(Illuminate\Support\Str::random(16));

// });

