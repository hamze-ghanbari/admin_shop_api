<?php

use App\Http\Controllers\Api\V1\OtpController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\V1\PermissionController;
use Illuminate\Support\Facades\Route;

Route::fallback((function(){
    return response()->json([
        'status' => 404,
        'message' => 'route not found',
        'hasError' => true
    ]);
}));

Route::controller(OtpController::class)->group(function () {
    Route::post('login', 'otp');
    Route::post('confirm', 'confirm');
    Route::get('resend/{token}', 'resendOtpCode');
    Route::get('logout', 'logout')->middleware('auth:api');
});


Route::middleware('auth:api')->apiResource('users', UserController::class)->except(['update', 'store']);
Route::controller(UserController::class)->prefix('users')->group(function() {
Route::put('{user}/birthDate', 'updateBirthDate');
Route::put('{user}/nationalCode', 'updateNationalCode');
Route::put('{user}/fullName',  'updateFullName');
});

Route::apiResource('users.roles', RoleController::class)->except(['destroy', 'show', 'update']);
Route::apiResource('roles', RoleController::class)->except('show');
Route::get('roles/{role}/status/{status}', [RoleController::class, 'changeStatus']);

Route::get('users/{user}/permissions', [UserController::class, 'showUserPermissions']);
Route::get('roles/{role}/permissions', [RoleController::class, 'showRolePermissions']);
Route::post('roles/{role}/permissions', [RoleController::class, 'addPermissionsToRole']);
Route::get('permissions', PermissionController::class);



