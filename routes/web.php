<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\ExchangeRateController;
use App\Http\Controllers\UserSettingController;


Route::get('/', function () {
    return view('app');
});

Route::get('/user', [UserController::class, 'user'])->middleware('auth:sanctum');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

Route::get('/test/{provider}', [SocialAuthController::class, 'redirectToProvider']);
Route::post('/auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback']);


Route::resource('category', CategoryController::class);
Route::resource('payment', PaymentController::class);

Route::get('paymentType', PaymentTypeController::class)->name('paymentType');
Route::get('currency', CurrencyController::class)->name('currency');

Route::resource('user_setting', UserSettingController::class);

Route::get('exchangeRate', ExchangeRateController::class)->name('exchangeRate');


Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');
