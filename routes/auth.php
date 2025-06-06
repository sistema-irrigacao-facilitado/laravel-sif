<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\UserLoginController;
use Illuminate\Support\Facades\Route;



Route::prefix('user')->group(function () {

    Route::get('login', [UserLoginController::class, 'showLoginForm'])
    ->name('user.login');

    Route::post('login', [UserLoginController::class, 'login']);

    Route::get('logout', function () {
        Auth::guard('web')->logout();
        return redirect('/');
    })->name('user.logout');

    Route::get('register', [RegisteredUserController::class, 'create'])
    ->name('user.register');

    Route::post('registerStore', [RegisteredUserController::class, 'store'])
    ->name('user.register.store');
});



Route::prefix('admin')->group(function () {

    Route::get('login', [AdminLoginController::class, 'showLoginForm'])
    ->name('admin');

    Route::post('login', [AdminLoginController::class, 'login'])->name('admin.login');

    Route::get('logout', function () {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    })->name('admin.logout');
});


