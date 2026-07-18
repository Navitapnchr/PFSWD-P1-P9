<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;

use App\Http\Controllers\Seller\DashboardController as SellerDashboard;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Seller\OrderController as SellerOrderController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index');

Route::get('/products/{product:slug}', [ProductController::class, 'show'])
    ->name('products.show');

Route::get('/categories/{category:slug}', [
    CategoryController::class,
    'show'
])->name('categories.show');

Route::get('/tentang', [HomeController::class, 'tentang']);


// ====================== BUYER ======================
Route::middleware(['auth', 'role:buyer'])->group(function () {

    Route::get('/dashboard', [
        OrderController::class,
        'dashboard'
    ])->name('dashboard');

    Route::get('/profile', [
        ProfileController::class,
        'show'
    ])->name('profile');

    // CART
    Route::get('/cart', [
        CartController::class,
        'index'
    ])->name('cart.index');

    Route::post('/cart/{product}', [
        CartController::class,
        'store'
    ])->name('cart.store');

    Route::delete('/cart/{cart}', [
        CartController::class,
        'destroy'
    ])->name('cart.destroy');

    // CHECKOUT
    Route::get('/checkout', [
        CheckoutController::class,
        'index'
    ])->name('checkout.index');

    Route::post('/checkout', [
        CheckoutController::class,
        'store'
    ])->name('checkout.store');

    // ORDER
    Route::get('/orders', [
        OrderController::class,
        'index'
    ])->name('orders.index');

    Route::post('/orders/{order}/cancel', [
        OrderController::class,
        'cancel'
    ])->name('orders.cancel');

    // PAYMENT (P9)
    Route::get('/orders/{order}/payment', [
        PaymentController::class,
        'show'
    ])->name('orders.payment');

    Route::post('/orders/{order}/payment', [
        PaymentController::class,
        'upload'
    ])->name('orders.payment.upload');
});


// ====================== SELLER ======================
Route::middleware(['auth', 'role:seller'])
    ->prefix('seller')
    ->name('seller.')
    ->group(function () {

        Route::get('/dashboard', [
            SellerDashboard::class,
            'index'
        ])->name('dashboard');

        // CRUD PRODUK SELLER
        Route::resource('products', SellerProductController::class);

        // ORDER SELLER
        Route::resource('orders', SellerOrderController::class)
            ->only(['index', 'show']);

        Route::post('/orders/{order}/verify', [
            SellerOrderController::class,
            'verify'
        ])->name('orders.verify');

        Route::post('/orders/{order}/reject', [
            SellerOrderController::class,
            'reject'
        ])->name('orders.reject');

        Route::post('/orders/{order}/ship', [
            SellerOrderController::class,
            'ship'
        ])->name('orders.ship');
    });


// ====================== ADMIN ======================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [
            AdminDashboard::class,
            'index'
        ])->name('dashboard');

        Route::resource(
            'categories',
            AdminCategoryController::class
        );
    });


// ====================== AUTH USER ======================
Route::middleware(['auth'])->group(function () {

    Route::post('/products/{product}/reviews', [
        ReviewController::class,
        'store'
    ])->name('reviews.store');
});

require __DIR__.'/auth.php';