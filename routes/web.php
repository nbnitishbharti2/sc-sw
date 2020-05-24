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

		/* Permission Routes */
		Route::get('/add-permission', 'RoleController@permission')->name('add.permission');
		Route::post('/store-permission', 'RoleController@storePermission')->name('store.permission');
		
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


		/* Fee Routes */
		Route::get('/view-fee', 'FeeController@index')->name('view.fee');
		Route::get('/add-fee', 'FeeController@create')->name('add.fee');
		Route::post('/store-fee', 'FeeController@store')->name('store.fee');
		Route::get('/edit-fee/{fee_id}', 'FeeController@edit')->name('edit.fee');
		Route::post('/update-fee', 'FeeController@update')->name('update.fee');
		Route::get('/delete-fee/{fee_id}', 'FeeController@delete')->name('delete.fee');
		Route::get('/restore-fee/{fee_id}', 'FeeController@restore')->name('restore.fee');


		/* Fee For Classes Routes */
		Route::get('/view-fee-for-classes', 'FeeForClassController@index')->name('view.fee-for-classes');
		Route::get('/add-fee-for-classes/{fee_id}', 'FeeForClassController@addFeeForClasses')->name('add.fee-for-classes');
		Route::post('/store-fee-for-classes', 'FeeForClassController@storeFeeForClasses')->name('store.fee-for-classes');
		Route::get('/edit-fee-for-classes/{fee_id}', 'FeeForClassController@edit')->name('edit.fee-for-classes');
		Route::post('/update-fee-for-classes', 'FeeForClassController@update')->name('update.fee-for-classes');


		/* Facility Routes */
		Route::get('/view-facility', 'FacilityController@index')->name('view.facility');
		Route::get('/add-facility', 'FacilityController@create')->name('add.facility');
		Route::post('/store-facility', 'FacilityController@store')->name('store.facility');
		Route::get('/edit-facility/{facility_id}', 'FacilityController@edit')->name('edit.facility');
		Route::post('/update-facility', 'FacilityController@update')->name('update.facility');
		Route::get('/delete-facility/{facility_id}', 'FacilityController@delete')->name('delete.facility');
		Route::get('/restore-facility/{facility_id}', 'FacilityController@restore')->name('restore.facility');


		/* Type Routes */
		Route::get('/view-type', 'TypeController@index')->name('view.type');
		Route::get('/add-type', 'TypeController@create')->name('add.type');
		Route::post('/store-type', 'TypeController@store')->name('store.type');
		Route::get('/edit-type/{type_id}', 'TypeController@edit')->name('edit.type');
		Route::post('/update-type', 'TypeController@update')->name('update.type');
		Route::get('/delete-type/{type_id}', 'TypeController@delete')->name('delete.type');
		Route::get('/restore-type/{type_id}', 'TypeController@restore')->name('restore.type');


		/* Payment Mode Routes */
		Route::get('/view-payment-mode', 'PaymentModeController@index')->name('view.payment_mode');
		Route::get('/add-payment-mode', 'PaymentModeController@create')->name('add.payment_mode');
		Route::post('/store-payment-mode', 'PaymentModeController@store')->name('store.payment_mode');
		Route::get('/edit-payment-mode/{payment_mode_id}', 'PaymentModeController@edit')->name('edit.payment_mode');
		Route::post('/update-payment-mode', 'PaymentModeController@update')->name('update.payment_mode');
		Route::get('/delete-payment-mode/{payment_mode_id}', 'PaymentModeController@delete')->name('delete.payment_mode');
		Route::get('/restore-payment-mode/{payment_mode_id}', 'PaymentModeController@restore')->name('restore.payment_mode');


		/* Category Routes */
		Route::get('/view-category', 'CategoryController@index')->name('view.category');
		Route::get('/add-category', 'CategoryController@create')->name('add.category');
		Route::post('/store-category', 'CategoryController@store')->name('store.category');
		Route::get('/edit-category/{category_id}', 'CategoryController@edit')->name('edit.category');
		Route::post('/update-category', 'CategoryController@update')->name('update.category');
		Route::get('/delete-category/{category_id}', 'CategoryController@delete')->name('delete.category');
		Route::get('/restore-category/{category_id}', 'CategoryController@restore')->name('restore.category');


		/* Education Routes */
		Route::get('/view-education', 'EducationController@index')->name('view.education');
		Route::get('/add-education', 'EducationController@create')->name('add.education');
		Route::post('/store-education', 'EducationController@store')->name('store.education');
		Route::get('/edit-education/{education_id}', 'EducationController@edit')->name('edit.education');
		Route::post('/update-education', 'EducationController@update')->name('update.education');
		Route::get('/delete-education/{education_id}', 'EducationController@delete')->name('delete.education');
		Route::get('/restore-education/{education_id}', 'EducationController@restore')->name('restore.education');


		/* Blood Group Routes */
		Route::get('/view-blood-group', 'BloodGroupController@index')->name('view.blood_group');
		Route::get('/add-blood-group', 'BloodGroupController@create')->name('add.blood_group');
		Route::post('/store-blood-group', 'BloodGroupController@store')->name('store.blood_group');
		Route::get('/edit-blood-group/{blood_group_id}', 'BloodGroupController@edit')->name('edit.blood_group');
		Route::post('/update-blood-group', 'BloodGroupController@update')->name('update.blood_group');
		Route::get('/delete-blood-group/{blood_group_id}', 'BloodGroupController@delete')->name('delete.blood_group');
		Route::get('/restore-blood-group/{blood_group_id}', 'BloodGroupController@restore')->name('restore.blood_group');




		/*  All Ajax Routes */
		Route::post('/get-vehicle-no-from-vehicle', 'VehicleRootMapController@getVehicleNo')->name('get-vehicle-no-from-vehicle');
		Route::post('/get-vehicle-type-from-vehicle-root-map', 'StopageController@getVehicleType')->name('get-vehicle-type-from-vehicle-root-map');
		Route::post('/get-vehicle-no-from-vehicle-root-map', 'StopageController@getVehicleNo')->name('get-vehicle-no-from-vehicle-root-map');
		Route::post('/get-fee-head-frequency-from-fee-setting', 'FeeController@getFeeHeadFrequency')->name('get-fee-head-frequency-from-fee-setting');
		Route::post('/get-fee-frequency-from-fee-frequency', 'FeeController@getFeeFrequency')->name('get-fee-frequency-from-fee-frequency');
		Route::post('/get-frequency-value-from-fee-frequency', 'FeeController@getFeeFrequencyValue')->name('get-frequency-value-from-fee-frequency');
		/*Route::get('/test', 'HomeController@test')->name('test');*/
	});
});
