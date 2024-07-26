<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\UserController;

Route::get('/', function () {
    return view('app');
});

Route::get('/user', [UserController::class, 'user'])->middleware('auth:sanctum');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');


Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');
