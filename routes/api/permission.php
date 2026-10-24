<?php 

use App\Http\Controllers\Permission\PermissionController;

    Route::middleware('auth:api')->group(function() {
        Route::get('/', [PermissionController::class, 'index']);
    });