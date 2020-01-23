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

Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');

Route::group([
    'prefix' => 'admin'
], function () {
    Route::get('users', 'UserController@index')->name('show_users');
    Route::get('user/create', 'UserController@create')->name('add_user');
    Route::get('roles', 'RoleController@index')->name('show_roles');
    Route::get('permissions', 'PermissionController@index')->name('show_permission');
    Route::get('reset_password', 'UserController@showResetView')->name('reset_password');
});