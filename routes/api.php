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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'API\UserController@login');
Route::post('/register', 'API\UserController@register');
Route::post('driver/login', 'API\DriverController@login');
Route::post('driver/register', 'API\DriverController@register');
Route::get('driver/get-monopolists/{duration_type?}','API\DriverController@getMonopolists');

Route::group(['middleware' => 'auth:api_driver'], function()
{
    Route::post('driver/details', 'API\DriverController@details');
    Route::get('driver/get-nearest-trips', 'API\TripController@getNearestTrips');
    Route::post('driver/make-a-trip','API\DriverController@makeATrip');
    Route::patch('driver/pick-trip/{id}', 'API\TripController@pickTrip');
});
Route::group(['middleware' => 'auth:api'], function()
{
    Route::resource('/trips', 'API\TripController');
    Route::post('/details', 'API\UserController@details');
});
