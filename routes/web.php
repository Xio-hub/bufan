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

// Auth::routes();
// Authentication Routes
Route::get('administer/management/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('administer/management/login', 'Auth\LoginController@login');
Route::post('administer/management/logout', 'Auth\LoginController@logout')->name('logout');

Route::group([
    'namespace' => 'Admin',
    'prefix' => 'administer/management',
    'middleware' => ['auth']
], function () {
    Route::get('/', 'HomeController@index');
    Route::get('home', 'HomeController@index')->name('admin.home');
    Route::get('password', 'UserController@showResetView')->name('admin.password.edit');
    Route::patch('password', 'UserController@updatePassword')->name('admin.password.update');
});

Route::group([
    'namespace' => 'Admin',
    'prefix' => 'administer/management',
    'middleware' => ['auth','role:super_admin']
], function () {
    /*super admin*/
    Route::get('users', 'UserController@index')->name('admin.index');
    Route::get('create', 'UserController@create')->name('admin.create');
    Route::post('users', 'UserController@store')->name('admin.store');

    Route::get('users/{id}/password', 'UserController@showUserResetView')->name('admin.user.password.edit');
    Route::patch('users/{id}/password', 'UserController@updateUserPassword')->name('admin.user.password.update');
    Route::delete('users/{id}', 'UserController@destroy')->where('id', '\d+');

    Route::get('roles', 'RoleController@index')->name('roles.index');
    Route::get('permissions', 'PermissionController@index')->name('permissions.index');
});

Route::group([
    'namespace' => 'Admin',
    'prefix' => 'administer/management',
    'middleware' => ['auth','permission:商家管理']
], function () {
    Route::get('merchants', 'MerchantController@index')->name('merchants.index');
    Route::get('merchants/create', 'MerchantController@create')->name('merchants.create');
    Route::post('merchants', 'MerchantController@store')->name('merchants.store');
    Route::get('merchants/{id}/edit', 'MerchantController@edit')->where('id','\d+')->name('merchants.edit');
    Route::put('merchants/{id}', 'MerchantController@update')->name('merchants.update');
    Route::delete('merchants/{id}', 'MerchantController@destroy');

    Route::get('merchants/{id}/password', 'MerchantController@showResetView')->name('admin.merchant.password.edit');
    Route::patch('merchants/{id}/password', 'MerchantController@updatePassword')->name('admin.merchant.password.update');
});

//==========================================================================================================================
Route::get('merchant/management/login', 'Merchant\LoginController@showLoginForm')->name('merchant.login');
Route::post('merchant/management/login', 'Merchant\LoginController@login');
Route::post('merchant/management/logout', 'Merchant\LoginController@logout')->name('merchant.logout');

Route::group([
    'namespace' => 'Merchant',
    'prefix' => 'merchant/management',
    'middleware' => ['auth:merchant']
], function () {
    Route::get('/', 'HomeController@index');
    Route::get('home', 'HomeController@index')->name('merchant.home');
    Route::get('password', 'UserController@showResetView')->name('merchant.password.edit');
    Route::patch('password', 'UserController@updatePassword')->name('merchant.password.update');

    Route::get('/index/edit', 'IndexController@edit')->name('merchant.index.edit');
    Route::put('/index', 'IndexController@update')->name('merchant.index.update');

    Route::get('/products', 'ProductController@index')->name('merchant.product.index');
    Route::get('/products/create', 'ProductController@create')->name('merchant.product.create');
    Route::post('/products', 'ProductController@store')->name('merchant.product.store');
    Route::get('/products/{id}/edit', 'ProductController@edit')->where('id','\d+')->name('merchant.product.edit');
    Route::put('/products/{id}', 'ProductController@update')->where('id','\d+')->name('merchant.product.update');
    Route::delete('/products/{id}', 'ProductController@destroy')->where('id','\d+')->name('merchant.product.destroy');

    Route::get('/spaces/categories', 'SpaceCategoryController@index')->name('merchant.space.category.index');
    Route::get('/spaces/categories/create', 'SpaceCategoryController@create')->name('merchant.space.category.create');
    Route::post('/spaces/categories', 'SpaceCategoryController@store')->name('merchant.space.category.store');
    Route::get('/spaces/categories/{id}/edit', 'SpaceCategoryController@edit')->name('merchant.space.category.edit');
    Route::patch('/spaces/categories/{id}', 'SpaceCategoryController@update')->name('merchant.space.category.update');
    Route::delete('/spaces/categories/{id}', 'SpaceCategoryController@destroy')->name('merchant.space.category.destroy');

    Route::get('/spaces', 'SpaceController@index')->name('merchant.space.index');
    Route::get('/spaces/create', 'SpaceController@create')->name('merchant.space.create');
    Route::post('/spaces', 'SpaceController@store')->name('merchant.space.store');
    Route::get('/spaces/{id}/edit', 'SpaceController@edit')->where('id','\d+')->name('merchant.space.edit');
    Route::put('/spaces/{id}', 'SpaceController@update')->where('id','\d+')->name('merchant.space.update');
    Route::delete('/spaces/{id}', 'SpaceController@destroy')->where('id','\d+')->name('merchant.space.destroy');

    Route::get('/styles/categories', 'StyleCategoryController@index')->name('merchant.style.category.index');
    Route::get('/styles/categories/create', 'StyleCategoryController@create')->name('merchant.style.category.create');
    Route::post('/styles/categories', 'StyleCategoryController@store')->name('merchant.style.category.store');
    Route::get('/styles/categories/{id}/edit', 'StyleCategoryController@edit')->name('merchant.style.category.edit');
    Route::patch('/styles/categories/{id}', 'StyleCategoryController@update')->name('merchant.style.category.update');
    Route::delete('/styles/categories/{id}', 'StyleCategoryController@destroy')->name('merchant.style.category.destroy');

    Route::get('/styles', 'StyleController@index')->name('merchant.style.index');
    Route::get('/styles/create', 'StyleController@create')->name('merchant.style.create');
    Route::post('/styles', 'StyleController@store')->name('merchant.style.store');
    Route::get('/styles/{id}', 'StyleController@edit')->where('id','\d+')->name('merchant.style.edit');
    Route::put('/styles/{id}', 'StyleController@update')->where('id','\d+')->name('merchant.style.update');
    Route::delete('/styles/{id}', 'StyleController@destroy')->where('id','\d+')->name('merchant.style.destroy');

    Route::get('/materials', 'MaterialController@index')->name('merchant.material.index');
    Route::get('/materials/create', 'MaterialController@create')->name('merchant.material.create');
    Route::post('/materials', 'MaterialController@store')->name('merchant.material.store');
    Route::get('/materials/{id}', 'MaterialController@edit')->where('id','\d+')->name('merchant.material.edit');
    Route::put('/materials/{id}', 'MaterialController@update')->where('id','\d+')->name('merchant.material.update');
    Route::delete('/materials/{id}', 'MaterialController@destroy')->where('id','\d+')->name('merchant.material.destroy');

    Route::get('/panoramas', 'PanoramaController@index')->name('merchant.panorama.index');
    Route::get('/panoramas/create', 'PanoramaController@create')->name('merchant.panorama.create');
    Route::post('/panoramas', 'PanoramaController@store')->name('merchant.panorama.store');
    Route::get('/panoramas/{id}', 'PanoramaController@edit')->where('id','\d+')->name('merchant.panorama.edit');
    Route::put('/panoramas/{id}', 'PanoramaController@update')->where('id','\d+')->name('merchant.panorama.update');
    Route::delete('/panoramas/{id}', 'PanoramaController@destroy')->where('id','\d+')->name('merchant.panorama.destroy');

    Route::get('/vertical_views', 'VerticalViewController@index')->name('merchant.vertical_view.index');
    Route::get('/vertical_views/create', 'VerticalViewController@create')->name('merchant.vertical_view.create');
    Route::post('/vertical_views', 'VerticalViewController@store')->name('merchant.vertical_view.store');
    Route::get('/vertical_views/{id}', 'VerticalViewController@edit')->where('id','\d+')->name('merchant.vertical_view.edit');
    Route::put('/vertical_views/{id}', 'VerticalViewController@update')->where('id','\d+')->name('merchant.vertical_view.update');
    Route::delete('/vertical_views/{id}', 'VerticalViewController@destroy')->where('id','\d+')->name('merchant.vertical_view.destroy');

    Route::get('categories/{id}/edit' , 'CategoryController@edit')->where('id', '\d+')->name('merchant.category.edit');
    Route::patch('categories/{id}' , 'CategoryController@update')->where('id', '\d+')->name('merchant.category.update');

    Route::get('introductions' , 'IntroductionController@index')->where('id', '\d+')->name('merchant.introduction.index');
    Route::get('introductions/{id}/edit' , 'IntroductionController@edit')->where('id', '\d+')->name('merchant.introduction.edit');
    Route::patch('introductions/{id}' , 'IntroductionController@update')->where('id', '\d+')->name('merchant.introduction.update');

    Route::post('products/images' ,'ProductController@storeImage')->name('product.image.upload');
    Route::post('products/cover' ,'ProductController@storeCover')->name('product.cover.upload');
    Route::post('products/videos' ,'ProductController@storeVideo')->name('product.video.upload');

    Route::post('spaces/categories/cover' ,'SpaceCategoryController@storeCover')->name('space.category.cover.upload');
    Route::post('spaces/images' ,'SpaceController@storeImage')->name('space.image.upload');
    Route::post('spaces/cover' ,'SpaceController@storeCover')->name('space.cover.upload');
    Route::post('spaces/videos' ,'SpaceController@storeVideo')->name('space.video.upload');

    Route::post('styles/categories/cover' ,'StyleCategoryController@storeCover')->name('style.category.cover.upload');
    Route::post('styles/images' ,'StyleController@storeImage')->name('style.image.upload');
    Route::post('styles/cover' ,'StyleController@storeCover')->name('style.cover.upload');
    Route::post('styles/videos' ,'StyleController@storeVideo')->name('style.video.upload');
});