<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\PumpController;
use Illuminate\Support\Facades\Route;

Route::controller(DeviceController::class)->group(function () {

    Route::get('/device/add',  'add')
        ->middleware(['auth:web', 'verified'])
        ->name('user.device.add');

    Route::get('/device/{id}/relatorio', 'report')
        ->middleware(['auth:web', 'verified'])
        ->name('user.device.report');

    Route::get('/device/{id}/configuracao', 'config')
        ->middleware(['auth:web', 'verified'])
        ->name('user.device.config');

    // Device: Metodo PUT
    Route::put('/device/add',  'upUserId')
        ->middleware(['auth:web', 'verified'])
        ->name('user.device.add');

    Route::put('/device/{id}/configuracao',  'modeUpdate')
        ->middleware(['auth:web', 'verified'])
        ->name('user.device.modeUpdate');

    Route::put('device/{id}/plant/selected',  'plantSelect')
        ->middleware(['auth:web', 'verified'])
        ->name('user.device.plant.selected');
    
    Route::put('device/{id}/pump/selected',  'pumpSelect')
        ->middleware(['auth:web', 'verified'])
        ->name('user.device.pump.selected');
});

Route::get('device/{id}/plant', [PlantController::class, 'select'])
    ->middleware(['auth:web', 'verified'])
    ->name('user.device.plant');

Route::get('device/{id}/pump', [PumpController::class, 'select'])
    ->middleware(['auth:web', 'verified'])
    ->name('user.device.pump');

