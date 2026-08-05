<?php

use App\Http\Controllers\api\OrdersController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::post('order/store', [OrdersController::class, 'store']);
    Route::post('order/update/{id}', [OrdersController::class, 'update']);
    Route::get('order/show/{id}', [OrdersController::class, 'showSingleOrder']);
    Route::get('order/dashboard-stats', [OrdersController::class, 'dashboardStats']);
    Route::get('order/list/{status?}/{from?}/{to?}', [OrdersController::class, 'index']);
});
