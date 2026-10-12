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
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\LocationController;
use App\Http\Controllers\Client\SearchController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgetController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\AboutController;
use App\Http\Controllers\Client\FaqController;

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

Route::prefix('cart')->middleware('auth:sanctum')->name('cart.')->group(function () {
    Route::post('/items', [CartController::class, 'store'])->name('store');
    Route::patch('/items/{productId}', [CartController::class, 'update'])->name('update');
    Route::delete('/items/{productId}', [CartController::class, 'destroy'])->name('destroy');
});

Route::prefix('profile')->middleware('auth:sanctum')->name('profile.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/likes', [UserController::class, 'likes'])->name('likes');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
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

Route::get('search/suggest', [SearchController::class, 'suggest'])
//    ->middleware('throttle:60,1')
    ->name('search.suggest');


Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])
        ->name('login');

    Route::get('/register', [RegisterController::class, 'index'])
        ->name('register');

    Route::post('register', [RegisterController::class, 'store'])->name('register.store');
    Route::post('login', [LoginController::class, 'store'])->name('login.store');


    Route::get('/forgot-password', [
        ForgetController::class,
        'index',
    ])->name('password.request');

    Route::post('/forgot-password/send-code', [
        ForgetController::class,
        'sendCode',
    ])->name('password.code.send');

    Route::post('/forgot-password/verify-code', [
        ForgetController::class,
        'verifyCode',
    ])->name('password.code.verify');

    Route::post('/forgot-password/reset', [
        ForgetController::class,
        'reset',
    ])->name('password.reset');



});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])
        ->name('logout');
});

Route::get('contact',[ContactController::class,'index'])->name('contact');
Route::post('contact',[ContactController::class,'store'])->name('contact.store');

Route::get('about',[AboutController::class,'index'])->name('about');
Route::get('faq',[FaqController::class,'index'])->name('faq');


