<?php

use App\Http\Controllers\Device\DeviceIotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Rota usada pelo ESP32 para enviar as leituras e receber a configuração.
// Fica em api.php para não passar por sessão nem por CSRF.
Route::post('/device/write', [DeviceIotController::class, 'write'])
    ->name('device.write');

Route::get('/teste', function(){  // não precisa usar um middleware
    return "aaaaaaaaaaaaaaaaaaaaaa";
});
