<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\ExchangeRateController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Social\SocialAuthController;
use App\Http\Controllers\UserSettingController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function (){
    Route::get('/user', [UserController::class, 'user'])->name('user');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('report', ReportController::class)->name('report');

    Route::apiResource('category', CategoryController::class);
    Route::apiResource('payment', PaymentController::class);


    Route::get('/totalSum', [PaymentController::class, 'getTotalSum'])->name('payment.totalSum');
    Route::get('/paymentsByType', [PaymentController::class, 'getPaymentsByType'])->name('payment.getPaymentsByType');


    Route::get('paymentType', PaymentTypeController::class)->name('paymentType');
    Route::get('currency', CurrencyController::class)->name('currency');

    Route::apiResource('user_setting', UserSettingController::class)->only(['index', 'store']);
});


Route::post('/login', [AuthController::class, 'authenticate'])->name('login');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

Route::get('/test/{provider}', [SocialAuthController::class, 'redirectToProvider']);

Route::post('/auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback'])->name('auth.social.callback');

Route::get('exchangeRate', ExchangeRateController::class)->name('exchangeRate');
