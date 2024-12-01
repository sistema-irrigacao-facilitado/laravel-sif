<?php

use App\Http\Controllers\Device\DeviceController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\PumpController;
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

    Route::post('/device/{id}/config',  'modeUpdate')
        ->middleware(['auth:web', 'verified'])
        ->name('user.device.modeUpdate');

    Route::put('device/{id}/plant/selected',  'plantSelect')
        ->middleware(['auth:web', 'verified'])
        ->name('user.device.plant.selected');

    Route::put('device/{id}/pump/selected',  'pumpSelect')
        ->middleware(['auth:web', 'verified'])
        ->name('user.device.pump.selected');

    Route::put('device/unlink',  'unlink')
        ->name('user.device.unlink');

});

Route::get('device/{id}/plant', [PlantController::class, 'select'])
    ->middleware(['auth:web', 'verified'])
    ->name('user.device.plant');

Route::get('device/{id}/pump', [PumpController::class, 'select'])
    ->middleware(['auth:web', 'verified'])
    ->name('user.device.pump');
