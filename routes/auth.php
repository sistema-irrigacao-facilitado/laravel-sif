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

    Route::middleware('auth:web')->get('dashboard', [UserController::class, 'index'])
    ->name('user.dashboard');

    Route::get('logout', function () {
        Auth::guard('web')->logout();
        return redirect('/');
    })->name('user.logout');
});






Route::prefix('admin')->group(function () {

    Route::get('login', [AdminLoginController::class, 'showLoginForm'])
    ->name('admin.login');

    Route::post('login', [AdminLoginController::class, 'login']);

    Route::middleware('auth:admin')->get('dashboard', [AdmCollaboratorController::class, 'index'])
    ->name('admin.dashboard');

    Route::get('logout', function () {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    })->name('admin.logout');
});

Route::middleware('auth:web')->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index']);
});

Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dashboard', [AdmCollaboratorController::class, 'index']);
});



Route::middleware('guest')->group(function () {

    // Rotas de login para usuários
    Route::get('/login', [UserLoginController::class, 'showLoginForm'])->name('login'); // Rota padrão para usuários
    Route::post('/login', [UserLoginController::class, 'login'])->name('user.login');

    // Rotas de login para administradores
    Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminLoginController::class, 'login']);


    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    // Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
    //     ->name('password.request');

    // Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
    //     ->name('password.email');

    // Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
    //     ->name('password.reset');

    // Route::post('reset-password', [NewPasswordController::class, 'store'])
    //     ->name('password.store');
});

// Route::middleware('auth:web')->group(function () {
//     Route::get('verify-email', EmailVerificationPromptController::class)
//         ->name('verification.notice');

//     Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
//         ->middleware(['signed', 'throttle:6,1'])
//         ->name('verification.verify');

//     Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
//         ->middleware('throttle:6,1')
//         ->name('verification.send');

//     Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
//         ->name('password.confirm');

//     Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

//     Route::put('password', [PasswordController::class, 'update'])->name('password.update');

//     Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
//         ->name('logout');
//     Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])
//     ->name('logout');
// });
