<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\PostController;

Route::get('/',[DashboardController::class,'index'])->name('dashboard');

Route::prefix('category')->name('category.')->group(function (){

    Route::get('/create',[CategoryController::class,'create'])->name('create');
    Route::get('/data', [CategoryController::class, 'data'])->name('data');
    Route::get('/{category}/edit',[CategoryController::class,'edit'])->name('edit');
    Route::post('/',[CategoryController::class,'store'])->name('store');
    Route::put('/{category}',[CategoryController::class,'update'])->name('update');
    Route::get('/',[CategoryController::class,'index'])->name('index');
    Route::delete('/{category}',[CategoryController::class,'destroy'])->name('destroy');
});

Route::prefix('vendor')->name('vendor.')->group(function () {

    Route::get('/create', [VendorController::class, 'create'])->name('create');
    Route::get('/data', [VendorController::class, 'data'])->name('data');
    Route::get('/{vendor}/edit', [VendorController::class, 'edit'])->name('edit');
    Route::post('/', [VendorController::class, 'store'])->name('store');
    Route::put('/{vendor}', [VendorController::class, 'update'])->name('update');
    Route::get('/', [VendorController::class, 'index'])->name('index');
    Route::delete('/{vendor}', [VendorController::class, 'destroy'])->name('destroy');
});

Route::prefix('user')->name('user.')->group(function () {

    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::get('/data', [UserController::class, 'data'])->name('data');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::put('/{user}', [UserController::class, 'update'])->name('update');
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
});

Route::prefix('vendor')->name('vendor.')->group(function () {

    Route::get('/create', [VendorController::class, 'create'])->name('create');
    Route::get('/data', [VendorController::class, 'data'])->name('data');
    Route::get('/{vendor}/edit', [VendorController::class, 'edit'])->name('edit');
    Route::post('/', [VendorController::class, 'store'])->name('store');
    Route::put('/{vendor}', [VendorController::class, 'update'])->name('update');
    Route::get('/', [VendorController::class, 'index'])->name('index');
    Route::delete('/{vendor}', [VendorController::class, 'destroy'])->name('destroy');

});

Route::prefix('product')->name('product.')->group(function () {

    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::get('/data', [ProductController::class, 'data'])->name('data');
    Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::post('/', [ProductController::class, 'store'])->name('store');
    Route::put('/{product}', [ProductController::class, 'update'])->name('update');
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');

});

Route::prefix('role')->name('role.')->group(function () {

    Route::get('/create', [RoleController::class, 'create'])->name('create');
    Route::get('/data', [RoleController::class, 'data'])->name('data');
    Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');
    Route::post('/', [RoleController::class, 'store'])->name('store');
    Route::put('/{role}', [RoleController::class, 'update'])->name('update');
    Route::get('/', [RoleController::class, 'index'])->name('index');
    Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');

});

Route::prefix('permission')->name('permission.')->group(function () {

    Route::get('/create', [PermissionController::class, 'create'])->name('create');
    Route::get('/data', [PermissionController::class, 'data'])->name('data');
    Route::get('/{permission}/edit', [PermissionController::class, 'edit'])->name('edit');
    Route::post('/', [PermissionController::class, 'store'])->name('store');
    Route::put('/{permission}', [PermissionController::class, 'update'])->name('update');
    Route::get('/', [PermissionController::class, 'index'])->name('index');
    Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('destroy');

});

Route::prefix('cart')->name('cart.')->group(function () {

    Route::get('/data', [CartController::class, 'data'])->name('data');
    Route::get('/{cart}', [CartController::class, 'show'])->name('show');
    Route::get('/', [CartController::class, 'index'])->name('index');

});

Route::prefix('order')->name('order.')->group(function () {
    Route::get('/data', [OrderController::class, 'data'])->name('data');
    Route::get('/{order}', [OrderController::class, 'show'])->name('show');
    Route::get('/', [OrderController::class, 'index'])->name('index');
});

Route::prefix('coupon')->name('coupon.')->group(function () {

    Route::get('/data', [CouponController::class, 'data'])
        ->name('data');

    Route::get('/create', [CouponController::class, 'create'])
        ->name('create');

    Route::post('/', [CouponController::class, 'store'])
        ->name('store');

    Route::get('/{coupon}/edit', [CouponController::class, 'edit'])
        ->name('edit');

    Route::put('/{coupon}', [CouponController::class, 'update'])
        ->name('update');

    Route::delete('/{coupon}', [CouponController::class, 'destroy'])
        ->name('destroy');

    Route::get('/', [CouponController::class, 'index'])
        ->name('index');
});

Route::prefix('media')->name('media.')->group(function () {
    Route::get('/data', [MediaController::class, 'data'])->name('data');
    Route::get('/', [MediaController::class, 'index'])->name('index');
});

Route::prefix('menu')->name('menu.')->group(function () {

    Route::get('/data', [MenuController::class, 'data'])
        ->name('data');

    Route::get('/create', [MenuController::class, 'create'])
        ->name('create');

    Route::post('/', [MenuController::class, 'store'])
        ->name('store');

    Route::get('/{menu}/edit', [MenuController::class, 'edit'])
        ->name('edit');

    Route::put('/{menu}', [MenuController::class, 'update'])
        ->name('update');

    Route::delete('/{menu}', [MenuController::class, 'destroy'])
        ->name('destroy');

    Route::get('/', [MenuController::class, 'index'])
        ->name('index');

});

Route::prefix('setting')->name('setting.')->group(function () {
    Route::get('/', [SettingController::class, 'index'])->name('index');
    Route::put('/', [SettingController::class, 'update'])->name('update');
});

Route::prefix('banner')->name('banner.')->group(function () {

    Route::get('/data', [BannerController::class, 'data'])
        ->name('data');

    Route::get('/create', [BannerController::class, 'create'])
        ->name('create');

    Route::post('/', [BannerController::class, 'store'])
        ->name('store');

    Route::get('/{banner}/edit', [BannerController::class, 'edit'])
        ->name('edit');

    Route::put('/{banner}', [BannerController::class, 'update'])
        ->name('update');

    Route::delete('/{banner}', [BannerController::class, 'destroy'])
        ->name('destroy');

    Route::get('/', [BannerController::class, 'index'])
        ->name('index');

});


Route::prefix('post')->name('post.')->group(function () {

    Route::get('/data', [PostController::class, 'data'])
        ->name('data');

    Route::get('/create', [PostController::class, 'create'])
        ->name('create');

    Route::post('/', [PostController::class, 'store'])
        ->name('store');

    Route::get('/{post}/edit', [PostController::class, 'edit'])
        ->name('edit');

    Route::put('/{post}', [PostController::class, 'update'])
        ->name('update');

    Route::delete('/{post}', [PostController::class, 'destroy'])
        ->name('destroy');

    Route::get('/', [PostController::class, 'index'])
        ->name('index');

});
