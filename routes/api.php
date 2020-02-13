<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'namespace' => 'Api\v1',
    'prefix'    => 'v1'
], function() {
    Route::get('admins','AdminController@list');
    Route::get('merchants','MerchantController@list');

    Route::post('users/login', 'PassportController@login');

    Route::get('init', 'InitController@init');
    Route::get('background', 'InitController@getIndexBackground');
    Route::get('categories', 'CategoryController@list');
    Route::get('search', 'SearchController@search');

    Route::get('products', 'ProductController@list');
    Route::get('products/{id}', 'ProductController@detail')->where('id','\d+');

    Route::get('spaces/categories', 'SpaceController@getCategories');
    Route::get('spaces','SpaceController@list');
    Route::get('spaces/{id}','SpaceController@detail')->where('id','\d+');

    Route::get('styles/categories', 'StyleController@categories');
    Route::get('styles','StyleController@list');
    Route::get('styles/{id}','StyleController@detail')->where('id','\d+');

    Route::get('panoramas/materials', 'PanoramaController@getMaterials');
    Route::get('panoramas/styles', 'PanoramaController@getStyles');
    Route::get('panoramas/detail', 'PanoramaController@detail');
    Route::get('panoramas/vertical_views', 'PanoramaController@getVerticalView');

    Route::get('courses/background', 'CourseController@background');
    Route::get('courses/outlines', 'CourseController@outlines');
    Route::get('courses/{course_id}', 'CourseController@getCourse');
    Route::get('courses/outlines/{outline_id}', 'CourseController@getOutline');
    Route::get('users/{merchant_id}/courses/orders', 'CourseController@getUserOrders');
    Route::get('users/{merchant_id}/courses/{course_id}', 'CourseController@checkUserIsBought');

    Route::get('merchants/{merchant_id}/introductions/categories', 'IntroductionController@categories');
    Route::get('merchants/{merchant_id}/introductions/{id}', 'IntroductionController@detail')->where('id', '\d+');

    Route::get('search', 'SearchController@search');
});


Route::group([
    'namespace' => 'Api\v2',
    'prefix'    => 'v2'
], function() {
    Route::get('admins','AdminController@list');
    Route::get('merchants','MerchantController@list');

    Route::post('users/login', 'PassportController@login');

    Route::get('init', 'InitController@init');
    Route::get('index', 'InitController@index');
    Route::get('categories', 'CategoryController@list');
    Route::get('search', 'SearchController@search');

    Route::get('products', 'ProductController@list');
    Route::get('products/{id}', 'ProductController@detail')->where('id','\d+');

    Route::get('spaces/categories', 'SpaceController@getCategories');
    Route::get('spaces','SpaceController@list');
    Route::get('spaces/{id}','SpaceController@detail')->where('id','\d+');

    Route::get('styles/categories', 'StyleController@categories');
    Route::get('styles','StyleController@list');
    Route::get('styles/{id}','StyleController@detail')->where('id','\d+');

    Route::get('panoramas/materials', 'PanoramaController@getMaterials');
    Route::get('panoramas/styles', 'PanoramaController@getStyles');
    Route::get('panoramas/detail', 'PanoramaController@detail');
    Route::get('panoramas/vertical_views', 'PanoramaController@getVerticalView');

    Route::get('courses/background', 'CourseController@background');
    Route::get('courses/outlines', 'CourseController@outlines');
    Route::get('courses/{course_id}', 'CourseController@getCourse');
    Route::get('courses/outlines/{outline_id}', 'CourseController@getOutline');
    Route::get('users/{merchant_id}/courses/orders', 'CourseController@getUserOrders');
    Route::get('users/{merchant_id}/courses/{course_id}', 'CourseController@checkUserIsBought');

    Route::get('merchants/{merchant_id}/introductions/categories', 'IntroductionController@categories');
    Route::get('merchants/{merchant_id}/introductions/{id}', 'IntroductionController@detail')->where('id', '\d+');

    Route::get('search', 'SearchController@search');
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});