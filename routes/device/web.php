<?php

use App\Http\Controllers\Device\DeviceController;
use Illuminate\Support\Facades\Route;

Route::controller(DeviceController::class)->group(function(){
    Route::post('/device/write', 'write')
        ->name('device.write');

});
