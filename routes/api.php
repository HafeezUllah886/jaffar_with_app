<?php

use App\Http\Controllers\api\authController;
use App\Http\Controllers\api\nonFinanancialInfoController;
use App\Http\Controllers\api\OrderbookerLocationsController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [authController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [authController::class, 'logout']);
    Route::get('products', [nonFinanancialInfoController::class, 'products']);
    Route::get('units', [nonFinanancialInfoController::class, 'units']);
    Route::get('/storelocation', [OrderbookerLocationsController::class, 'store']);
});
