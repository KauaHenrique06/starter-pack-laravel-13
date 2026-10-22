<?php 

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/login/2fa', [AuthController::class, 'login2fa']);

Route::middleware('auth:api')->group(function() {
    Route::patch('/toggle-2fa', [AuthController::class, 'toggle2fa']);
});