<?php

use App\Http\Controllers\api\authController;
use App\Http\Controllers\api\NonFinancialInfoController;
use App\Http\Controllers\api\OrderbookerLocationsController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [authController::class, 'login']);
Route::get('/products', [NonFinancialInfoController::class, 'products']);
Route::get('/units', [NonFinancialInfoController::class, 'units']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [authController::class, 'logout']);

    Route::get('/storelocation', [OrderbookerLocationsController::class, 'store']);
});
