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

// Route::middleware("guest")->group(function(){
    Route::get('/users', 'UserController@index');
    Route::post('/users', 'UserController@store');
    Route::put('/users/{user}', 'UserController@update');
    Route::delete('/users/{user}', 'UserController@destroy');
    Route::post('/password/{token}', 'PasswordController@create')->name('password');
    Route::post("/login", "AuthController@login");
// });

// Route::middleware("auth")->group(function(){

    // Route::middleware("admin")->group(function(){

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

        Route::get('/categories', 'CategoryController@index');
        Route::post('/categories', 'CategoryController@store');
        Route::put('/categories/{category}', 'CategoryController@update');
        Route::delete('/categories/{category}', 'CategoryController@destroy');

        Route::get('/vehicles', 'VehicleController@index');
        Route::post('/vehicles', 'VehicleController@store');
        Route::put('/vehicles/{vehicle}', 'VehicleController@update');
        Route::delete('/vehicles/{vehicle}', 'VehicleController@destroy');

        Route::get('/dropoffs', 'DropOffController@index');
        Route::post('/dropoffs', 'DropOffController@store');
        Route::put('/dropoffs/{dropoff}', 'DropOffController@update');
        Route::delete('/dropoffs/{dropoff}', 'DropOffController@destroy');

        Route::get('/settings', 'SettingController@index');
        Route::post('/settings', 'SettingController@store');
        Route::put('/settings/{setting}', 'SettingController@update');
        Route::delete('/settings/{setting}', 'SettingController@destroy');

        Route::get('/reports/{dropoff}', 'ReportController@show');
    // });


    Route::get('/rentals', 'RentalController@index');
    Route::post('/rentals', 'RentalController@store');
    Route::put('/rentals/{rental}', 'RentalController@update');
    Route::delete('/rentals/{rental}', 'RentalController@destroy');
// });

