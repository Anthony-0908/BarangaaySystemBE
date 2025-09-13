<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\LoginController;  
use App\Http\Controllers\API\Admin\UserController; 
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\API\Admin\RoleController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/login', [LoginController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [LoginController::class, 'logout']);


Route::apiResource('/users', UserController::class);
Route::apiResource('/roles', RoleController::class);
Route::apiResource('/roles', RoleController::class);



Route::post('/forgot-password', [PasswordResetLinkController::class, 'sendResetLink']);
Route::post('/reset-password', [PasswordResetLinkController::class, 'resetPassword']);
