<?php

use App\Http\Controllers\Api\V1\Banner\BannerController;
use App\Http\Controllers\Api\V1\Mail\MailController;
use App\Http\Controllers\Api\V1\Mail\MailFile\MailFileController;
use App\Http\Controllers\Api\V1\Otp\OtpController;
use App\Http\Controllers\Api\V1\Product\Brand\BrandController;
use App\Http\Controllers\Api\V1\Product\Category\CategoryController;
use App\Http\Controllers\Api\V1\Product\Color\ColorProductController;
use App\Http\Controllers\Api\V1\Product\Delivery\DeliveryController;
use App\Http\Controllers\Api\V1\Product\Gallery\GalleryProductController;
use App\Http\Controllers\Api\V1\Product\Meta\MetaProductController;
use App\Http\Controllers\Api\V1\Product\ProductController;
use App\Http\Controllers\Api\V1\User\Permission\PermissionController;
use App\Http\Controllers\Api\V1\User\Role\RoleController;
use App\Http\Controllers\Api\V1\User\UserController;
use Illuminate\Support\Facades\Route;

// otp --------------------
Route::controller(OtpController::class)->group(function () {
    Route::post('login', 'otp');
    Route::post('confirm', 'confirm');
    Route::post('resendCode', 'resendOtpCode');
    Route::get('logout', 'logout');
});

// users -------------------------
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

    Route::post('search', 'searchUser');
});

// roles -------------------
Route::apiResource('roles', RoleController::class)->except('show');
Route::controller(RoleController::class)->prefix('roles')->group(function () {
    Route::post('search', 'searchRole');
    Route::get('{role}/status/{status}', [RoleController::class, 'changeStatus']);
    Route::get('{role}/permissions', [RoleController::class, 'showRolePermissions']);
    Route::post('{role}/permissions', [RoleController::class, 'storeRolePermissions']);
});

// permissions ------------------------
Route::get('permissions', PermissionController::class);

// category_products -------------------------
Route::apiResource('categoryProduct', CategoryController::class)->except('show');
Route::controller(CategoryController::class)->prefix('categoryProduct')->group(function () {
    Route::post('search', 'searchCategory');
    Route::get('{categoryProduct}/status/{status}', 'changeStatus');
});

// brands -------------------------
Route::apiResource('brands', BrandController::class)->except('show');
Route::controller(BrandController::class)->prefix('brands')->group(function () {
    Route::post('search', 'searchBrand');
    Route::get('{brand}/status/{status}', 'changeStatus');
});

// mails
Route::apiResource('mails', MailController::class);
Route::controller(MailController::class)->prefix('mails')->group(function () {
    Route::post('search', 'searchMail');
    Route::get('{mail}/sendGroup', 'sendGroupMail');
    Route::get('{mail}/sendSingle', 'sendSingleMail');
    Route::get('{mail}/status/{status}', 'changeStatus');

    // mail files
    Route::apiResource('{mail}/files', MailFileController::class)->except('show');
    Route::get('{mail}/files/{file}/status/{status}', [MailFileController::class, 'changeStatus']);
});

// banners
Route::get('banners/all', [BannerController::class, 'displayableBanners']);
Route::apiResource('banners', BannerController::class);
Route::post('banners/search', [BannerController::class, 'searchBanner']);
Route::get('banners/{banner}/status/{status}', [BannerController::class, 'changeStatus']);

// deliveries
Route::apiResource('deliveries', DeliveryController::class)->except('show');
Route::get('deliveries/{delivery}/status/{status}', [DeliveryController::class, 'changeStatus']);

// products
Route::apiResource('products', ProductController::class);
Route::controller(ProductController::class)->prefix('products')->group(function(){
Route::get('{product}/category','categoryProduct');
Route::get('{product}/brand', 'brandProduct');
Route::get('{product}/metas', 'productMetas');
Route::get('{product}/colors','productColors');
Route::get('{product}/gallery','productGallery');
Route::post('search', 'searchProduct');
Route::get('{product}/status/{status}', 'changeStatus');
});

// meta products
Route::apiResource('products.meta', MetaProductController::class)->parameters([
    'meta' => 'meta'
])->except(['index', 'show']);
Route::delete('products/{product}/meta', [MetaProductController::class, 'multiDelete']);

// color products
Route::apiResource('products.color', ColorProductController::class)
    ->except(['index', 'show', 'update']);

// gallery products
Route::apiResource('products.gallery', GalleryProductController::class)
    ->except(['index', 'show', 'update']);


Route::fallback((function () {
    return response()->json([
        'status' => 404,
        'message' => 'Route Not Found',
        'hasError' => true,
        'result' => null
    ]);
}));
