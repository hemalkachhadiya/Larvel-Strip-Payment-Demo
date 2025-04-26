<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
// use Smarttech\StripePayment\Controllers\StripeController;
use Smarttech\StripePayment\Controllers\CartController;

// Route::get('stripe', [StripeController::class, 'index']);
// Route::post('stripe/payment', [StripeController::class, 'processPayment'])->name('stripe.payment');

// Route::view('/stripe/success', 'stripe::success')->name('stripe.success');
// Route::view('/stripe/cancel', 'stripe::cancel')->name('stripe.cancel');

// Route::group(['namespace' => 'Smarttech\\StripePayment\\Controllers'], function () {
//     Route::get('stripe/checkout', [StripeController::class, 'checkout'])->name('stripe.checkout');
//     Route::post('stripe/order', [StripeController::class, 'placeOrder'])->name('stripe.order');
//     Route::post('stripe/payment', [StripeController::class, 'processPayment'])->name('stripe.payment');
//     Route::get('stripe/success', [StripeController::class, 'success'])->name('stripe.success');
//     Route::get('stripe/cancel', [StripeController::class, 'cancel'])->name('stripe.cancel');
// });

Route::middleware('web')->group(function () {
    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cartstripe.add');
    Route::get('/cart', [CartController::class, 'showCart'])->name('cartstripe.cart');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('cartstripe.checkout');
    Route::post('/process-checkout', [CartController::class, 'processCheckout'])->name('cartstripe.process');
    Route::get('/payment-success', [CartController::class, 'success'])->name('cartstripe.success');
    Route::get('/payment-cancel', [CartController::class, 'cancel'])->name('cartstripe.cancel');
    Route::post('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');

    // Route::get('/cart/count', function () {
    //     $count = DB('cart_items')::where('user_id', auth()->id())->count();

    //     return response()->json(['count' => $count]);
    // })->name('cart.count');

    // Route::get('/cart/count', function () {
    //     $count = \DB::table('cart_items')->where('user_id', auth()->id())->count();
    //     return response()->json(['count' => $count]);
    // })->name('cart.count')->middleware('web');

});
