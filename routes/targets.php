<?php

use App\Http\Controllers\OrderbookerTargetController;
use App\Http\Controllers\SelfTargetController;
use App\Http\Controllers\TargetsController;
use App\Http\Middleware\adminCheck;
use App\Http\Middleware\confirmPassword;
use Illuminate\Support\Facades\Route;

Route::middleware('auth', adminCheck::class)->group(function () {

    Route::resource('targets', TargetsController::class);
    Route::get('target/delete/{id}', [TargetsController::class, 'destroy'])->name('target.delete')->middleware(confirmPassword::class);

    Route::resource('self_targets', SelfTargetController::class);
    Route::get('self_target/delete/{id}', [SelfTargetController::class, 'destroy'])->name('self_target.delete')->middleware(confirmPassword::class);
    Route::get("selftarger/getcat/{id}", [SelfTargetController::class, 'getcat']);

    Route::resource('orderbooker_targets', OrderbookerTargetController::class);
    Route::get('orderbooker_target/delete/{id}', [OrderbookerTargetController::class, 'delete'])->name('orderbooker_target.delete')->middleware(confirmPassword::class);

});

