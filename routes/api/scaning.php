<?php

use App\Http\Controllers\api\DeepFreezerScaneController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::post('deep-freezer-scan', [DeepFreezerScaneController::class, 'scan']);
    Route::get('deep-freezer-scans', [DeepFreezerScaneController::class, 'index']);

});
