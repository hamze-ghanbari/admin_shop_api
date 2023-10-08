<?php

use App\Http\Controllers\Api\V1\OtpController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\V1\PermissionController;
use Illuminate\Support\Facades\Route;



Route::controller(OtpController::class)->group(function () {
    Route::post('login', 'otp');
    Route::post('confirm', 'confirm');
    Route::get('resend/{token}', 'resendOtpCode');
    Route::get('logout', 'logout');
});


Route::apiResource('users', UserController::class)->except(['update', 'store', 'create', 'edit']);
Route::controller(UserController::class)->prefix('users')->group(function () {

    Route::put('edit/birthDate', 'updateBirthDate');
    Route::put('edit/nationalCode', 'updateNationalCode');
    Route::put('edit/fullName', 'updateFullName');

    Route::get('{user}/profile', 'profile');

    Route::get('{user}/roles', 'showUserRoles');
    Route::post('{user}/roles', 'storeUserRoles');

    Route::get('{user}/permissions', 'showUserPermissions');
    Route::post('{user}/permissions', 'storeUserPermissions');

});

Route::apiResource('roles', RoleController::class)->except('show');
Route::get('roles/{role}/status/{status}', [RoleController::class, 'changeStatus']);
Route::get('roles/{role}/permissions', [RoleController::class, 'showRolePermissions']);
Route::post('roles/{role}/permissions', [RoleController::class, 'storeRolePermissions']);

Route::get('permissions', PermissionController::class);

//Route::get('users/{user}/permissions', [UserController::class, 'showUserPermissions']);
//Route::get('roles/{role}/permissions', [RoleController::class, 'showRolePermissions']);
//Route::post('roles/{role}/permissions', [RoleController::class, 'addPermissionsToRole']);
//Route::get('permissions', PermissionController::class);



Route::fallback((function () {
    return response()->json([
        'status' => 404,
        'message' => 'route not found',
        'hasError' => true,
        'result' => null
    ]);
}));
