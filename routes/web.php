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
    Route::get('show_users', 'IndexController@showUsersView')->name('show_users');
    Route::get('add_user', 'IndexController@showAddUserView')->name('add_user');
    Route::get('show_roles', 'IndexController@showRolesView')->name('show_roles');
    Route::get('show_permission', 'IndexController@showPermissionsView')->name('show_permission');
    Route::get('reset_password', 'IndexController@showResetView')->name('reset_password');
});