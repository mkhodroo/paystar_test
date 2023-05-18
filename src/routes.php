<?php 

use Illuminate\Support\Facades\Route;
use Mkhodroo\PaystarTest\Controllers\CheckoutController;
use Mkhodroo\PaystarTest\Controllers\PaymentController;



Route::name('paystar.')->prefix('paystar/')->middleware('web')->group(function(){
    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('pay', [PaymentController::class, 'getPayLink'])->name('getPayLink');
    Route::get('callback', [PaymentController::class, 'callback'])->name('callback');
});