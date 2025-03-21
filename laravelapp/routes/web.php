<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FurnitureGoodController;
use App\Http\Controllers\GoodRatingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('homepage');
})->name('homepage');

Route::permanentRedirect('dashboard', '/');

Route::resource('categories', CategoryController::class)
    ->except(['show'])
    ->middleware('auth');

Route::get('categories/{category}', [CategoryController::class, 'show'])
    ->name('categories.show');

Route::resource('goods', FurnitureGoodController::class)
    ->except(['index', 'show'])
    ->middleware('auth');

Route::get('goods', [FurnitureGoodController::class, 'index'])
    ->name('goods.index');

Route::get('goods/{good}', [FurnitureGoodController::class, 'show'])
    ->name('goods.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/admin', [UserController::class, 'makeAdmin'])->name('users.make-admin');

    Route::post('/goods/{good}/addToCart', [FurnitureGoodController::class, 'addToCart'])->name('goods.add-to-cart');

    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::delete('/cart/{cartItem}/remove-all', [\App\Http\Controllers\CartController::class, 'removeItems'])->name('cartItem.remove-all');
    Route::patch('cart/{cartItem}/decrease', [\App\Http\Controllers\CartController::class, 'removeOneItem'])->name('cartItem.remove-one');
    Route::patch('cart/{cartItem}/increase', [\App\Http\Controllers\CartController::class, 'addOneItem'])->name('cartItem.add-one');

    Route::post('/orders/make', [\App\Http\Controllers\CartController::class, "createOrder"])->name('orders.make');

    Route::resource('orders', \App\Http\Controllers\OrderController::class);

    Route::get('/my-orders', [\App\Http\Controllers\OrderController::class, 'myOrders'])->name('orders.personal');

    Route::post('/goods/{good}/ratings', [GoodRatingController::class, 'addOrUpdate'])->name('ratings.add-or-update');
    Route::delete('/ratings/{rating}', [GoodRatingController::class, 'destroy'])->name('ratings.destroy');
});


require __DIR__ . '/auth.php';
