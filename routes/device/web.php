<?php

use App\Http\Controllers\Device\DeviceIotController;
use Illuminate\Support\Facades\Route;

Route::controller(DeviceIotController::class)->group(function(){
    Route::post('/device/write', 'write')
        ->name('device.write');

});
