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

Route::group(['prefix' => 'dxkj'], function (\Illuminate\Routing\Router $route) {

	$route->get('/', 'HomeController@index')->name('home');

	$route->group(['middleware' => 'check-login', 'namespace' => 'Admin'], function () use ($route) {
		$route->resource('/users', 'UserController', ['names' => [
			'index' => 'user',
			'create' => 'user-create',
			'store' => 'user-store',
			'edit' => 'user-edit',
			'update' => 'user-update',
			'destroy' => 'user-delete',
		]]);

		$route->resource('/roles', 'RoleController', ['names' => [
			'index' => 'role',
			'create' => 'role-create',
			'store' => 'role-store',
			'edit' => 'role-edit',
			'update' => 'role-update',
			'destroy' => 'role-delete',
		]]);

		$route->resource('/permissions', 'PerController', ['names' => [
			'index' => 'permission',
			'create' => 'per-create',
			'store' => 'per-store',
			'edit' => 'per-edit',
			'update' => 'per-update',
			'destroy' => 'per-delete',
		]]);

		$route->get('/users-role/{id}', 'InnerApiController@getUserRoleById');
		$route->get('/role-permissions/{id}', 'InnerApiController@getRolePerById');
		$route->get('/add-user-role/{id}', 'UserController@addUserRole')->name('user.addRole');
		$route->post('/store-user-role/{id}', 'UserController@storeUserRole')->name('user.storeRole');
		$route->get('/add-role-per/{id}', 'RoleController@addRolePer')->name('role.addPer');
		$route->post('/store-role-per/{id}', 'RoleController@storeRolePer')->name('role.storePer');

		$route->get('media-manager', 'FileManageController@index')->name('media-index');
		$route->get('media-download', 'FileManageController@download')->name('media-download');
		$route->delete('media-delete', 'FileManageController@delete')->name('media-delete');
		$route->post('media-new-folder', 'FileManageController@newFolder')->name('media-new-folder');
		$route->post('media-upload', 'FileManageController@upload')->name('media-upload');
		$route->put('media-move', 'FileManageController@move')->name('media-move');

	});

	$route->get('/notAuth', 'CommonController@notAuth')->name('notAuth');

	$route->group(['namespace' => 'Api'], function () use ($route) {
		$route->post('/login', 'LoginController@login');
		$route->post('/logout', 'LoginController@logout');
		$route->post('/checkLogin', 'LoginController@checkLogin');
	});
});

Route::get('/test', 'TestController@index');
