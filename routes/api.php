<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\LoginController;  
use App\Http\Controllers\API\Admin\UserController; 
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\API\Admin\RoleController;
use App\Http\Controllers\API\Admin\PermissionController;

// Get authenticated user
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auth
Route::post('/login', [LoginController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [LoginController::class, 'logout']);

// Route::middleware(['auth:sanctum'])->group(function () {
//     Route::get('users', [UserController::class, 'index']);
// });

// Route::middleware(['auth:sanctum','role:Admin'])->group(function () {
//     Route::apiResource('users', UserController::class);
//     Route::apiResource('roles', RoleController::class);
// });

// // Protected (admin only)
Route::middleware(['auth:sanctum','role:Admin'])->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('roles', RoleController::class);

    Route::post('roles/{roleId}/toggle-permission', [PermissionController::class, 'togglePermission']);
    Route::post('users/{userId}/toggle-permission', [PermissionController::class, 'toggleUserPermission']);
});




// Route::middleware(['auth:sanctum', ])->group(function () {
//     Route::get('/admin-only', function () {
//         return response()->json(['message' => 'Welcome Admin!']);
//     });
// });

// Route::middleware(['auth:sanctum', 'role:Admin'])->group(function () {
//     Route::get('/manager-only', function () {
//         return response()->json(['message' => 'Welcome Manager!']);
//     });
// });


// Route::group(['middleware' => ['role:manager']], function () { ... });

// Password reset
Route::post('/forgot-password', [PasswordResetLinkController::class, 'sendResetLink']);
Route::post('/reset-password', [PasswordResetLinkController::class, 'resetPassword']);