<?php

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

Route::post('/users', 'UserController@store');
Route::post('/password/{token}', 'PasswordController@create')->name('password');

Route::middleware('guest')->group(function () {
    Route::post('/login', 'AuthController@login')->name('login');
});

Route::middleware('auth:api')->group(function () {
    Route::get('/users', 'UserController@index');
    Route::get('/users/{user}', 'UserController@show');
    Route::put('/users/{user}', 'UserController@update');
    Route::delete('/users/{user}', 'UserController@destroy');

    Route::get('/rentals', 'RentalController@index');
    Route::get('/rentals/{rental}', 'RentalController@show');
    Route::post('/rentals', 'RentalController@store');
    Route::put('/rentals/{rental}', 'RentalController@update');
    Route::delete('/rentals/{rental}', 'RentalController@destroy');

    Route::middleware('admin')->group(function () {
        Route::get('/brands', 'BrandController@index');
        Route::get('/brands/{brand}', 'BrandController@show');
        Route::post('/brands', 'BrandController@store');
        Route::put('/brands/{brand}', 'BrandController@update');
        Route::delete('/brands/{brand}', 'BrandController@destroy');

        Route::get('/carmodels', 'CarModelController@index');
        Route::get('/carmodels/{carmodel}', 'CarModelController@show');
        Route::post('/carmodels', 'CarModelController@store');
        Route::put('/carmodels/{carmodel}', 'CarModelController@update');
        Route::delete('/carmodels/{carmodel}', 'CarModelController@destroy');

        Route::get('/fuels', 'FuelController@index');
        Route::get('/fuels/{fuel}', 'FuelController@show');
        Route::post('/fuels', 'FuelController@store');
        Route::put('/fuels/{fuel}', 'FuelController@update');
        Route::delete('/fuels/{fuel}', 'FuelController@destroy');

        Route::get('/categories', 'CategoryController@index');
        Route::get('/categories/{category}', 'CategoryController@show');
        Route::post('/categories', 'CategoryController@store');
        Route::put('/categories/{category}', 'CategoryController@update');
        Route::delete('/categories/{category}', 'CategoryController@destroy');

        Route::get('/vehicles', 'VehicleController@index');
        Route::get('/vehicles/{vehicle}', 'VehicleController@show');
        Route::post('/vehicles', 'VehicleController@store');
        Route::put('/vehicles/{vehicle}', 'VehicleController@update');
        Route::delete('/vehicles/{vehicle}', 'VehicleController@destroy');

        Route::get('/dropoffs', 'DropOffController@index');
        Route::get('/dropoffs/{dropoff}', 'DropOffController@show');
        Route::post('/dropoffs', 'DropOffController@store');
        Route::put('/dropoffs/{dropoff}', 'DropOffController@update');
        Route::delete('/dropoffs/{dropoff}', 'DropOffController@destroy');

        Route::get('/settings', 'SettingController@index');
        Route::get('/settings/{setting}', 'SettingController@show');
        Route::post('/settings', 'SettingController@store');
        Route::put('/settings/{setting}', 'SettingController@update');
        Route::delete('/settings/{setting}', 'SettingController@destroy');

        Route::get('/reports/{dropoff}', 'ReportController@show');

        Route::get('/maintenances', 'MaintenanceController@index');
        Route::get('/maintenances/{maintenance}', 'MaintenanceController@show');
        Route::post('/maintenances', 'MaintenanceController@store');
        Route::put('/maintenances/{maintenance}', 'MaintenanceController@update');
        Route::delete('/maintenances/{maintenance}', 'MaintenanceController@destroy');

        Route::get('/cleanings', 'CleaningController@index');
        Route::get('/cleanings/{cleaning}', 'CleaningController@show');
        Route::post('/cleanings', 'CleaningController@store');
        Route::put('/cleanings/{cleaning}', 'CleaningController@update');
        Route::delete('/cleanings/{cleaning}', 'CleaningController@destroy');

        Route::post('/checkouts', 'CheckoutController@checkout');

        Route::get('/dashboard', 'DashboardController@index');
    });
});
