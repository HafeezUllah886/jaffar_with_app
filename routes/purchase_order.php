<?php

use App\Http\Controllers\PurchaseOrderController;
use App\Http\Middleware\adminCheck;
use App\Http\Middleware\confirmPassword;
use Illuminate\Support\Facades\Route;

Route::middleware('auth', adminCheck::class)->group(function () {

    Route::resource('purchase_order', PurchaseOrderController::class)->middleware(adminCheck::class);
    Route::get("purchase_order/delete/{id}", [PurchaseOrderController::class, 'destroy'])->name('purchase_order.delete')->middleware(confirmPassword::class);

});
