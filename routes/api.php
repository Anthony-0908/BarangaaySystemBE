<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Admin\UserController;
use App\Http\Controllers\API\Admin\RoleController;
use App\Http\Controllers\API\Admin\PermissionController;

// ----------------------------
// 🔐 AUTH ROUTES (JWT)
// ----------------------------
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:api');

// ----------------------------
// 🧍 USER INFO (protected)
// ----------------------------
Route::middleware('auth:api')->get('/me', function (Request $request) {
    return response()->json([
        'user' => $request->user(),
        'roles' => $request->user()->getRoleNames(),
    ]);
});

// ----------------------------
// 🧱 ADMIN PROTECTED ROUTES
// ----------------------------
Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('roles', RoleController::class);

    Route::post('roles/{roleId}/toggle-permission', [PermissionController::class, 'togglePermission']);
    Route::post('users/{userId}/toggle-permission', [PermissionController::class, 'toggleUserPermission']);
});
?>