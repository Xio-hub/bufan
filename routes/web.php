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

Route::namespace('Admin')->group(function () {
    Route::get('show_users', 'UserController@showUsersView')->name('show_users');
    Route::get('add_user', 'UserController@showAddUserView')->name('add_user');
    Route::get('show_roles', 'UserController@showRolesView')->name('show_roles');
    Route::get('show_permission', 'UserController@showPermissionsView')->name('show_permission');
});