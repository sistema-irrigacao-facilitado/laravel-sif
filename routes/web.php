<?php

use App\Http\Controllers\Adm\CollaboratorController as AdmCollaboratorController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth/user/login');
});

Route::get('/admin', function () {
    return view('auth/adm/login');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::post('/filter/{page}', [FilterController::class, 'filter'])
    ->name('filter.page');

Route::get('/filter_clear/{page}', [FilterController::class, 'filter'])
    ->name('filter_clear.page');

require __DIR__ . '/auth.php';
require __DIR__ . '/user/web.php';
require __DIR__ . '/admin/web.php';
