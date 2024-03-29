<?php

use App\Http\Controllers\Api\V1\Attribute\AttributeController;
use App\Http\Controllers\Api\V1\Attribute\Value\AttributeValueController;
use App\Http\Controllers\Api\V1\Banner\BannerController;
use App\Http\Controllers\Api\V1\Mail\MailController;
use App\Http\Controllers\Api\V1\Mail\MailFile\MailFileController;
use App\Http\Controllers\Api\V1\Otp\OtpController;
use App\Http\Controllers\Api\V1\Product\Category\CategoryController;
use App\Http\Controllers\Api\V1\Product\Color\ColorProductController;
use App\Http\Controllers\Api\V1\Delivery\DeliveryController;
use App\Http\Controllers\Api\V1\Product\Comment\CommentProductController;
use App\Http\Controllers\Api\V1\Product\Gallery\GalleryProductController;
use App\Http\Controllers\Api\V1\Product\ProductController;
use App\Http\Controllers\Api\V1\Product\Store\StoreController;
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
Route::apiResource('brands', StoreController::class)->except('show');
Route::controller(StoreController::class)->prefix('brands')->group(function () {
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

// store
Route::controller(StoreController::class)->group(function() {
    Route::post('products/{product}/store', 'store');
    Route::post('products/{product}/update', 'update');
});

// meta products
Route::apiResource('products.meta', CommentProductController::class)->parameters([
    'meta' => 'meta'
])->except(['index', 'show']);
Route::delete('products/{product}/meta', [CommentProductController::class, 'multiDelete']);

// color products
Route::apiResource('products.color', ColorProductController::class)
    ->except(['index', 'show', 'update']);

// gallery products
Route::apiResource('products.gallery', GalleryProductController::class)
    ->except(['index', 'show', 'update']);

// attribute category
Route::apiResource('attributes', AttributeController::class)
    ->except(['show']);
Route::post('attributes/search', [AttributeController::class, 'searchAttribute']);

// attribute value category
Route::apiResource('attributes.value', AttributeValueController::class)->except(['show'])->parameters([
    'value' => 'attributeValueCategory'
]);
Route::get('attributes/{attribute}/value/products', [AttributeValueController::class, 'getAttributeProducts']);

// comment products
Route::apiResource('products.comments', CommentProductController::class);
Route::prefix('products/{product}/comments/{comment}')->controller(CommentProductController::class)->group(function(){
   Route::get('approved/{approved}', 'approved');
   Route::get('status/{status}', 'status');
   Route::post('answer', 'answer');
});



Route::fallback((function () {
    return response()->json([
        'status' => 404,
        'message' => 'Route Not Found',
        'hasError' => true,
        'result' => null
    ]);
}));
