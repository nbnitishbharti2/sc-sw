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
	
});
