<?php 

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function() {
    Route::get('/', [UserController::class, 'index'])->middleware('can:user.view');
    Route::post('/', [UserController::class, 'store'])->middleware('can:user.create');
    Route::get('/{id}', [UserController::class, 'show'])->middleware('can:user.view');
    Route::patch('/{id}', [UserController::class, 'update'])->middleware('can:user.update');
    Route::delete('/{id}', [UserController::class, 'delete'])->middleware('can:user.delete');
});