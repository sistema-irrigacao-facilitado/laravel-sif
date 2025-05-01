<?php

use App\Http\Controllers\Adm\CollaboratorController as AdmCollaboratorController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\CollaboratorController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;



Route::prefix('user')->group(function () {

    Route::get('login', [UserLoginController::class, 'showLoginForm'])
    ->name('user.login');

    Route::post('login', [UserLoginController::class, 'login']);

    Route::get('logout', function () {
        Auth::guard('web')->logout();
        return redirect('/');
    })->name('user.logout');
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


