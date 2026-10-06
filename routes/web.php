<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\NewsletterController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\BlogController;
use App\Http\Controllers\Client\LikeController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\UserController;
use App\Http\Controllers\Client\AddressController;
use App\Http\Controllers\Client\ProvinceController;
use App\Http\Controllers\Client\CityController;
use App\Http\Controllers\Client\CountyController;
use App\Http\Controllers\Client\SectorController;
use App\Http\Controllers\Client\LocationController;

Route::get('/', [HomeController::class,'index'])->name('home');

Route::prefix('products')->name('products.')->group(function (){
    Route::get('/', [ProductController::class,'index'])->name('index');
    Route::get('/{product}', [ProductController::class,'show'])->name('show');
});

Route::prefix('blogs')->name('blogs.')->group(function (){
    Route::get('/', [BlogController::class,'index'])->name('index');
    Route::get('/{post:slug}', [BlogController::class, 'show'])->name('show');
});

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe']) ->name('newsletter.subscribe');

Route::post(
    '/likes/toggle',
    [LikeController::class, 'toggle']
)->name('likes.toggle');

Route::post('/cart/items', [CartController::class, 'store'])
    ->name('cart.items.store');

Route::prefix('cart')->name('cart.')->group(function () {
    Route::post('/items', [CartController::class, 'store'])->name('store');
    Route::patch('/items/{productId}', [CartController::class, 'update'])->name('update');
    Route::delete('/items/{productId}', [CartController::class, 'destroy'])->name('destroy');
});

Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/likes', [UserController::class, 'likes'])->name('likes');
    Route::put('/', [UserController::class, 'update'])->name('update');
    Route::put('/avatar', [UserController::class, 'updateAvatar'])->name('avatar');
    Route::put('/password', [UserController::class, 'updatePassword'])->name('password');

    Route::prefix('addresses')
        ->name('addresses.')
        ->group(function () {
            Route::get('/', [AddressController::class, 'index'])->name('index');
            Route::post('/', [AddressController::class, 'store'])->name('store');
            Route::put('/{address}', [AddressController::class, 'update'])->name('update');
            Route::patch('/{address}/default', [AddressController::class, 'makeDefault'])->name('default');
            Route::delete('/{address}', [AddressController::class, 'destroy'])->name('destroy');
        });
});

// Iran locations
Route::controller(LocationController::class)->group(function () {
     Route::get('/provinces', 'provinces')->name('locations.provinces');
    Route::get('/provinces/{province}/counties', 'counties')->name('locations.counties');
    Route::get('/counties/{county}/sectors', 'sectors')->name('locations.sectors');
    Route::get('/sectors/{sector}/cities', 'cities')->name('locations.cities');
 });
