<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExchangeRateController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Social\SocialAuthController;
use App\Http\Controllers\UserSettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;


Route::middleware('auth:sanctum')->group(function (){
    Route::get('/user', [UserController::class, 'user'])->name('user');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('report', ReportController::class)->name('report');

    Route::apiResource('category', CategoryController::class)->only(['index']);
    Route::apiResource('payment', PaymentController::class)->only(['store','destroy']);

    Route::get('/totalSum', [PaymentController::class, 'getTotalSum'])->name('payment.totalSum');
    Route::get('/paymentsByType', [PaymentController::class, 'getPaymentsByType'])->name('payment.getPaymentsByType');

    Route::get('paymentType', PaymentTypeController::class)->name('paymentType');

    Route::apiResource('user_setting', UserSettingController::class)->only(['index', 'store']);
});

Route::post('/login', [AuthController::class, 'authenticate'])->name('login');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

Route::get('/getLogo', [AppController::class, 'getLogo'])->name('getLogo');

Route::get('/test/{provider}', [SocialAuthController::class, 'redirectToProvider']);

Route::post('/auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback'])->name('auth.social.callback');

Route::get('exchangeRate', ExchangeRateController::class)->name('exchangeRate');

Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('language.locale');


Route::get('/locale/translations', [LocaleController::class, 'translations'])->name('locale.translations');
Route::post('/locale/{locale}', [LocaleController::class, 'store'])->name('locale.store');
Route::get('/locale/current', [LocaleController::class, 'currentLocale'])->name('locale.current');
