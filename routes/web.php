<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware'=>['localization']],function(){
	Route::get('/', 'Auth\LoginController@showLoginForm');
	Route::get('/verify-otp', 'UserController@verify_otp')->name('verify-otp');
	Route::post('/verify-otp', 'UserController@reset_password')->name('verify-otp');

	Auth::routes();

	Route::group(['middleware'=>['auth']],function(){
		/*Authenticated user routes*/
		Route::get('/home', 'HomeController@index')->name('home');
		Route::get('/profile', 'UserController@showProfile')->name('user-profile');
		Route::post('/profile', 'UserController@updateUserProfile')->name('update-user-profile');
		Route::get('/users', 'UserController@allUsers')->name('users');


		/*Superadmin user routes*/

		/* Class Routes*/
		Route::get('/view-class', 'ClassController@index')->name('view.class');
		Route::get('/add-class', 'ClassController@create')->name('add.class');
		Route::post('/store-class', 'ClassController@store')->name('store.class');
		Route::get('/edit-class/{class_id}', 'ClassController@edit')->name('edit.class');
		Route::post('/update-class', 'ClassController@update')->name('update.class');
		Route::get('/delete-class/{class_id}', 'ClassController@delete')->name('delete.class');
		Route::get('/restore-class/{class_id}', 'ClassController@restore')->name('restore.class');
		Route::get('/import-prv-session-class-section', 'ClassController@importPreviousSessionClassSection')->name('import.class.section');

		/* Section Routes*/
		Route::get('/view-section', 'SectionController@index')->name('view.section');
		Route::get('/add-section', 'SectionController@create')->name('add.section');
		Route::post('/store-section', 'SectionController@store')->name('store.section');
		Route::get('/edit-section/{section_id}', 'SectionController@edit')->name('edit.section');
		Route::post('/update-section', 'SectionController@update')->name('update.section');
		Route::get('/delete-section/{section_id}', 'SectionController@destroy')->name('delete.section');
		Route::get('/restore-section/{section_id}', 'SectionController@restore')->name('restore.section');
		
		/* Roles Routes*/
		Route::get('/view-roles', 'RoleController@index')->name('view.roles');
		Route::get('/add-roles', 'RoleController@create')->name('add.roles');
		Route::post('/store-roles', 'RoleController@store')->name('store.roles');
		Route::get('/edit-roles/{roles_id}', 'RoleController@edit')->name('edit.roles');
		Route::post('/update-roles', 'RoleController@update')->name('update.roles');
		Route::get('/delete-roles/{roles_id}', 'RoleController@destroy')->name('delete.roles');
		Route::get('/restore-roles/{roles_id}', 'RoleController@restore')->name('restore.roles');
		
		/*setting */
		Route::get('/school-details', 'SchoolDetailsController@index')->name('view.school-details');
		Route::post('/update-school-details', 'SchoolDetailsController@update')->name('update.school-details');
		Route::get('/sms-details', 'SchoolDetailsController@sms_details')->name('view.sms-details');
		Route::post('/update-sms-details', 'SchoolDetailsController@update_sms')->name('update.sms-details');
		Route::get('/smtp-details', 'SchoolDetailsController@smtp_details')->name('view.smtp-details');
		Route::post('/update-smtp-details', 'SchoolDetailsController@update_smtp')->name('update.smtp-details');
		
		/* Vehicle Type Routes */
		Route::get('/view-vehicle-type', 'VehicleTypeController@index')->name('view.vehicle_type');
		Route::get('/add-vehicle-type', 'VehicleTypeController@create')->name('add.vehicle_type');
		Route::post('/store-vehicle-type', 'VehicleTypeController@store')->name('store.vehicle_type');
		Route::get('/edit-vehicle-type/{vehicle_type_id}', 'VehicleTypeController@edit')->name('edit.vehicle_type');
		Route::post('/update-vehicle-type', 'VehicleTypeController@update')->name('update.vehicle_type');
		Route::get('/delete-vehicle-type/{vehicle_type_id}', 'VehicleTypeController@delete')->name('delete.vehicle_type');
		Route::get('/restore-vehicle-type/{vehicle_type_id}', 'VehicleTypeController@restore')->name('restore.vehicle_type');

		/* Vehicle Routes */
		Route::get('/view-vehicle', 'VehicleController@index')->name('view.vehicle');
		Route::get('/add-vehicle', 'VehicleController@create')->name('add.vehicle');
		Route::post('/store-vehicle', 'VehicleController@store')->name('store.vehicle');
		Route::get('/edit-vehicle/{vehicle_id}', 'VehicleController@edit')->name('edit.vehicle');
		Route::post('/update-vehicle', 'VehicleController@update')->name('update.vehicle');
		Route::get('/delete-vehicle/{vehicle_id}', 'VehicleController@delete')->name('delete.vehicle');
		Route::get('/restore-vehicle/{vehicle_id}', 'VehicleController@restore')->name('restore.vehicle');
		
		/* Root Routes */
		Route::get('/view-root', 'RootController@index')->name('view.root');
		Route::get('/add-root', 'RootController@create')->name('add.root');
		Route::post('/store-root', 'RootController@store')->name('store.root');
		Route::get('/edit-root/{root_id}', 'RootController@edit')->name('edit.root');
		Route::post('/update-root', 'RootController@update')->name('update.root');
		Route::get('/delete-root/{root_id}', 'RootController@delete')->name('delete.root');
		Route::get('/restore-root/{root_id}', 'RootController@restore')->name('restore.root');
		

		/* Vehicle Root Map Routes */
		Route::get('/view-vehicle-root-map', 'VehicleRootMapController@index')->name('view.vehicle_root_map');
		Route::get('/add-vehicle-root-map', 'VehicleRootMapController@create')->name('add.vehicle_root_map');
		Route::post('/store-vehicle-root-map', 'VehicleRootMapController@store')->name('store.vehicle_root_map');
		Route::get('/edit-vehicle-root-map/{vehicle_root_map_id}', 'VehicleRootMapController@edit')->name('edit.vehicle_root_map');
		Route::post('/update-vehicle-root-map', 'VehicleRootMapController@update')->name('update.vehicle_root_map');
		Route::get('/delete-vehicle-root-map/{vehicle_root_map_id}', 'VehicleRootMapController@delete')->name('delete.vehicle_root_map');
		Route::get('/restore-vehicle-root-map/{vehicle_root_map_id}', 'VehicleRootMapController@restore')->name('restore.vehicle_root_map');
		

		/* Stopage Routes */
		Route::get('/view-stopage', 'StopageController@index')->name('view.stopage');
		Route::get('/add-stopage', 'StopageController@create')->name('add.stopage');
		Route::post('/store-stopage', 'StopageController@store')->name('store.stopage');
		Route::get('/edit-stopage/{stopage_id}', 'StopageController@edit')->name('edit.stopage');
		Route::post('/update-stopage', 'StopageController@update')->name('update.stopage');
		Route::get('/delete-stopage/{stopage_id}', 'StopageController@delete')->name('delete.stopage');
		Route::get('/restore-stopage/{stopage_id}', 'StopageController@restore')->name('restore.stopage');
		Route::get('/import-stopage', 'StopageController@import')->name('import.stopage');

		/* Hostel Routes */
		Route::get('/view-hostel', 'HostelController@index')->name('view.hostel');
		Route::get('/add-hostel', 'HostelController@create')->name('add.hostel');
		Route::post('/store-hostel', 'HostelController@store')->name('store.hostel');
		Route::get('/edit-hostel/{hostel_id}', 'HostelController@edit')->name('edit.hostel');
		Route::post('/update-hostel', 'HostelController@update')->name('update.hostel');
		Route::get('/delete-hostel/{hostel_id}', 'HostelController@delete')->name('delete.hostel');
		Route::get('/restore-hostel/{hostel_id}', 'HostelController@restore')->name('restore.stopage');

		/* Room Routes */
		Route::get('/view-room', 'RoomController@index')->name('view.room');
		Route::get('/add-room', 'RoomController@create')->name('add.room');
		Route::post('/store-room', 'RoomController@store')->name('store.room');
		Route::get('/edit-room/{room_id}', 'RoomController@edit')->name('edit.room');
		Route::post('/update-room', 'RoomController@update')->name('update.room');
		Route::get('/delete-room/{room_id}', 'RoomController@delete')->name('delete.room');
		Route::get('/restore-room/{room_id}', 'RoomController@restore')->name('restore.room');

		/*  All Ajax Routes */
		Route::post('/get-vehicle-no-from-vehicle', 'VehicleRootMapController@getVehicleNo')->name('get-vehicle-no-from-vehicle');
		Route::post('/get-vehicle-type-from-vehicle-root-map', 'StopageController@getVehicleType')->name('get-vehicle-type-from-vehicle-root-map');
		Route::post('/get-vehicle-no-from-vehicle-root-map', 'StopageController@getVehicleNo')->name('get-vehicle-no-from-vehicle-root-map');
		/*Route::get('/test', 'HomeController@test')->name('test');*/
	});
});
