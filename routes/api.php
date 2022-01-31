<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
// Route::post('login',[AuthController::class,'login']);

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/signup', [AuthController::class, 'signUp']);
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/logout', [AuthController::class, 'logout']);
        Route::get('/getProductos',[ApiController::class,'getProductos']);
        Route::get('/getCotizaciones',[ApiController::class,'getCotizaciones']);
    });
    Route::post('/user', [AuthController::class, 'user']);
    Route::post('/storeCotizacion',[ApiController::class,'storeCotizacion']);
    Route::post('/deleteCotizacion',[ApiController::class,'deleteCotizacion']);
    Route::post('/updateUser',[AuthController::class,'updateUser']);
});

// Route::get('user', [AuthController::class, 'user']);
