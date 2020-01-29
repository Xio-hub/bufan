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
    Route::get('categories', 'CategoryController@list');

    Route::get('products', 'ProductController@list');
    Route::get('products/{id}', 'ProductController@detail')->where('id','\d+');

    Route::get('spaces/categories', 'SpaceController@categories');
    Route::get('spaces','SpaceController@list');
    Route::get('spaces/{id}','SpaceController@detail')->where('id','\d+');
    Route::get('spaces/search','SpaceController@search');

    Route::get('styles/categories', 'StyleController@categories');
    Route::get('styles','StyleController@list');
    Route::get('styles/{id}','StyleController@detail')->where('id','\d+');

    Route::get('material', 'MaterialController@list');
    Route::get('panoramas', 'PanoramaController@list');
    Route::get('vertical_views', 'VerticalViewContoller@list');

    Route::get('course_background', 'CourseController@background');
    Route::get('courses', 'CourseController@list');
    Route::get('courses/orders', 'CourseControlelr@orders');

    Route::get('companies/introductions/categories', 'IntroductionController@categories');
    Route::get('companies/introductions/{id}', 'IntroductionController@detail')->where('id', '\d+');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});