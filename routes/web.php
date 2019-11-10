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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('/home/location/{place}' ,'HomeController@getLocationJson');
Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/trip','TripController');
Route::get('/driver/register','DriverController@showRegisterForm')->name('driver.register');
Route::get('/driver/json-monopolists/{type?}','DriverController@jsonMonopolists')->name('driver.datatable');
Route::get('/driver/login','DriverController@showLoginForm')->name('driver.login');
Route::post('/driver/login','DriverController@login');
Route::resource('/driver', 'DriverController');
