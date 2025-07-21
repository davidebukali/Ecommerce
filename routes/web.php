<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

Route::post('/checkout', [OrderController::class, 'checkoutOrder'])->name('checkout.process');
Route::get('/checkout/confirmed/{order}', [OrderController::class, 'confirmed'])->name('checkout.confirmed'); // For the confirmation page


Route::middleware(['auth'])->group(function () {
    // Orders List Page
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    // Order Details Page
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.details');
});

