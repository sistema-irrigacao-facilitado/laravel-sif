<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/teste', function(){  // não precisa usar um middleware
    return "aaaaaaaaaaaaaaaaaaaaaa";
});
