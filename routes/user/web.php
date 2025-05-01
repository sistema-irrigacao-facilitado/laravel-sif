<?php

use App\Http\Controllers\Device\DeviceController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\PumpController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(DeviceController::class)->group(function () {

    Route::get('/device/add',  'add')
        ->middleware(['auth:web', 'verified'])
        ->name('user.device.add');

    Route::get('/device/{id}/report', 'report')
        ->middleware(['auth:web', 'verified'])
        ->name('user.device.report');

    Route::get('/device/{id}/config', 'config')
        ->middleware(['auth:web', 'verified'])
        ->name('user.device.config');

    Route::get('/device/search', 'search')
        ->middleware(['auth:web', 'verified'])
        ->name('user.device.report.search');

    // Device: Metodo PUT
    Route::put('/device/add',  'upUserId')
        ->middleware(['auth:web', 'verified'])
        ->name('user.device.add');

    Route::post('/device/{id}/config',  'modeUpdate')
        ->middleware(['auth:web', 'verified'])
        ->name('user.device.modeUpdate');

    Route::put('device/unlink',  'unlink')
        ->name('user.device.unlink');
});


Route::controller(UserController::class)->group(function () {
    Route::get('/user', 'index')
        ->middleware(['auth:web', 'verified'])
        ->name('dashboard');

    Route::get('/user/conf',  'conf')
        ->middleware(['auth:web', 'verified'])
        ->name('user.conf');

    Route::post('/user/conf/update',  'confUpdate')
        ->middleware(['auth:web', 'verified'])
        ->name('user.conf.update');

    Route::get('/user/conf/password',  'password')
        ->middleware(['auth:web', 'verified'])
        ->name('user.password');

    Route::post('/user/conf/password/update',  'passwordUpdate')
        ->middleware(['auth:web', 'verified'])
        ->name('user.password.update');
});

Route::controller(PlantController::class)->group(function () {

    Route::get('device/{id}/plant', 'select')
        ->middleware(['auth:web', 'verified'])
        ->name('user.device.plant');

    Route::put('device/{id}/plant/selected',  'plantSelect')
        ->middleware(['auth:web', 'verified'])
        ->name('user.device.plant.selected');

});


Route::controller(PumpController::class)->group(function () {
    
    Route::get('device/{id}/pump', 'select')
    ->middleware(['auth:web', 'verified'])
    ->name('user.device.pump');

    Route::put('device/{id}/pump/selected',  'pumpSelect')
        ->middleware(['auth:web', 'verified'])
        ->name('user.device.pump.selected');
});

