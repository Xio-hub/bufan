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

    Route::get('init', 'InitController@init');
    Route::get('background', 'InitController@getIndexBackground');
    Route::get('categories', 'CategoryController@list');

    Route::get('products', 'ProductController@list');
    Route::get('products/{id}', 'ProductController@detail')->where('id','\d+');

    Route::get('spaces/categories', 'SpaceController@getCategories');
    Route::get('spaces','SpaceController@list');
    Route::get('spaces/{id}','SpaceController@detail')->where('id','\d+');
    Route::get('spaces/search','SpaceController@search');

    Route::get('styles/categories', 'StyleController@categories');
    Route::get('styles','StyleController@list');
    Route::get('styles/{id}','StyleController@detail')->where('id','\d+');

    Route::get('materials', 'PanoramaController@getMaterials');
    Route::get('panoramas/styles', 'PanoramaController@getStyles');
    Route::get('panoramas/{id}', 'PanoramaController@getPanorama');
    Route::get('vertical_views', 'PanoramaController@getVerticalView');

    Route::get('courses/background', 'CourseController@background');
    Route::get('courses', 'CourseController@list');
    Route::get('courses/{id}', 'CourseController@detail');
    Route::get('courses/orders', 'CourseControlelr@getUserOrders');
    Route::get('courses/orders/search', 'CourseControlelr@searchUserOrders');
    Route::get('users/{user_id}/courses', 'CourseController@checkUserIsBought');

    Route::get('introductions/categories', 'IntroductionController@categories');
    Route::get('introductions/{id}', 'IntroductionController@detail')->where('id', '\d+');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});