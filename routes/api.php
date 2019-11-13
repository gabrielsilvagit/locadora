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

Route::get('/users', 'UserController@index');
Route::post('/users', 'UserController@store');
Route::put('/users/{user}', 'UserController@update');
Route::delete('/users/{user}', 'UserController@destroy');
Route::post('/password/{token}', 'PasswordController@create')->name('password');
Route::post("/login", "AuthController@login");

Route::get('/brands', 'BrandController@index');
Route::post('/brands', 'BrandController@store');
Route::put('/brands/{brand}', 'BrandController@update');
Route::delete('/brands/{brand}', 'BrandController@destroy');

Route::get('/carmodels', 'CarModelController@index');
Route::post('/carmodels', 'CarModelController@store');
Route::put('/carmodels/{carmodel}', 'CarModelController@update');
Route::delete('/carmodels/{carmodel}', 'CarModelController@destroy');

Route::get('/fuels', 'FuelController@index');
Route::post('/fuels', 'FuelController@store');
Route::put('/fuels/{fuel}', 'FuelController@update');
Route::delete('/fuels/{fuel}', 'FuelController@destroy');
