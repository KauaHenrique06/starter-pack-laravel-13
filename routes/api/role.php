<?php

use App\Http\Controllers\Role\RoleController;

Route::middleware('auth:api')->group(function() {
    Route::get('/', [RoleController::class, 'index'])->middleware('can:role.view');
    Route::get('/{id}', [RoleController::class, 'show'])->middleware('can:role.view');
    Route::put('/{id}', [RoleController::class, 'update'])->middleware('can:role.update');
});