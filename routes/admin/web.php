<?php

use App\Http\Controllers\Adm\CollaboratorController as AdmCollaboratorController;
use App\Http\Controllers\CollaboratorController;
use App\Http\Controllers\Device\DeviceController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PumpController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


Route::controller(DeviceController::class)->group(function () {
    Route::get('/admin/devices',  'list')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.devices');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/admin/users',  'list')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.users');
});

Route::controller(AdmCollaboratorController::class)->group(function () {
    Route::get('/admin/list',  'list')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.list');

    Route::get('/admin/dashboard', 'index')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.dashboard');
});

Route::controller(PumpController::class)->group(function () {
    Route::get('/admin/pumps',  'list')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.pumps');
});

Route::controller(PlantController::class)->group(function () {
    Route::get('/admin/plants',  'list')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.plants');
});
