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


Route::get('test2',function(){

	//return  'sdfsdf';
	
	\Mail::raw('test Mail to redirect environment is develop',function($m){
		$m->to('pawan@singsys.com');
		$m->cc('hitesh@singsys.com');
	});
});

Route::get('/', function () {
    return view('welcome');
});

Route::match(['post','get'],'/admin', 'LoginController@login');
Route::get('/logout','LoginController@logout');
Route::get('forgot-password', function () {
    return view('forgot-password');
});

Route::get('files-manager','Admin\FileController@index');
Route::match(['post','get'],'files-uploader','Admin\FileController@uploader');


//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// Admin Panel Route

Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){

	Route::get('dashboard','DashboardController@index')->middleware('canAccess:edit-role');
	Route::put('role/{id}/assign-permission','RoleController@assignPermission')->middleware('canAccess:edit-role');
	
	Route::resource('role','RoleController',['middleware'=>'canAccess:role[resource]','only'=>['index','update','store','create']]);
	Route::get('permission','PermissionController@index')->middleware('canAccess:list-permission');
	Route::put('permission/{id}','PermissionController@update')->middleware('canAccess:list-permission');
	Route::delete('permission/{id}','PermissionController@destroy')->middleware('canAccess:delete-permission');

	Route::get('setting','SettingController@index')->middleware('canAccess:list-setting');
	Route::post('setting','SettingController@store')->middleware('canAccess:add-setting');
	Route::put('setting/change/{id}','SettingController@change')->middleware('canAccess:change-setting');
	Route::delete('setting/{id}','SettingController@destroy')->middleware('canAccess:delete-setting');

	Route::resource('email-template','EmailTemplateController',['middleware'=>'canAccess:email-template[resource]','except'=>['show']]);
});


// Route::get('test2',function(){

// 	//var_dump(\Mail::send('mail.forget_password',['link'=>'google'],function($m){$m->to('hitesh@singsys.com');}));
// 	//
// 	$data = [];
// 	for ($i=0; $i <50 ; $i++) { 
// 		# code...
// 		$data[] = factory(App\User::class)->raw();

// 	}

// 	var_dump(App\User::bulkInsertIgnore($data));
// });