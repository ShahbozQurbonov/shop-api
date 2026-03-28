<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('change-password', [AuthController::class, 'changePassword']);
    Route::get('user', [AuthController::class, 'user']);
});