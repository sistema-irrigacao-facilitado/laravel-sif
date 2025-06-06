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
    
         Route::get('/admin/devices/new',  'new')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.devices.new');

         Route::get('/admin/devices/edit/{id}',  'edit')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.devices.edit');

         Route::post('/admin/devices/store',  'store')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.devices.store');

         Route::put('/admin/devices/update/{id}',  'update')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.devices.update');

        Route::get('/admin/devices/{id}/updateStatus/{status}',  'updateStatus')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.devices.updateStatus');

        Route::get('/admin/devices/delete/{id}', 'delete')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.devices.delete');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/admin/users',  'list')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.users');

          Route::get('/admin/users/new',  'new')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.users.new');

         Route::get('/admin/users/edit/{id}',  'edit')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.users.edit');

        Route::get('/admin/users/editPassword/{id}',  'editPassword')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.users.editPassword');

         Route::post('/admin/users/store',  'store')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.users.store');

         Route::put('/admin/users/update/{id}',  'update')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.users.update');

         Route::put('/admin/users/updatePassword/{id}',  'updatePassword')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.users.updatePassword');

        Route::get('/admin/users/{id}/updateStatus/{status}',  'updateStatus')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.users.updateStatus');

        Route::get('/admin/users/delete/{id}', 'delete')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.users.delete');
});

Route::controller(AdmCollaboratorController::class)->group(function () {
    Route::get('/admin/list',  'list')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.list');

    Route::get('/admin/dashboard', 'index')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.dashboard');

         Route::get('/admin/new',  'new')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.new');

         Route::get('/admin/edit',  'edit')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.edit');

         Route::post('/admin/store',  'store')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.store');

         Route::put('/admin/update/{id}',  'update')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.update');

        Route::get('/admin/{id}/updateStatus/{status}',  'updateStatus')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.updateStatus');

        Route::get('/admin/delete/{id}', 'delete')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.delete');

        Route::get('/admin/editPassword/{id}',  'editPassword')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.editPassword');

Route::put('/admin/updatePassword/{id}',  'updatePassword')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.updatePassword');
});

Route::controller(PumpController::class)->group(function () {
    Route::get('/admin/pumps',  'list')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.pumps');

        Route::get('/admin/pumps/new',  'new')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.pumps.new');

         Route::get('/admin/pumps/edit/{id}',  'edit')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.pumps.edit');

         Route::post('/admin/pumps/store',  'store')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.pumps.store');

         Route::put('/admin/pumps/update/{id}',  'update')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.pumps.update');

        Route::get('/admin/pumps/{id}/updateStatus/{status}',  'updateStatus')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.pumps.updateStatus');

        Route::get('/admin/pumps/delete/{id}', 'delete')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.pumps.delete');
});

Route::controller(PlantController::class)->group(function () {
    Route::get('/admin/plants',  'list')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.plants');

        Route::get('/admin/plants/new',  'new')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.plants.new');

         Route::get('/admin/plants/edit/{id}',  'edit')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.plants.edit');

         Route::post('/admin/plants/store',  'store')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.plants.store');

         Route::put('/admin/plants/update/{id}',  'update')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.plants.update');

        Route::get('/admin/plants/{id}/updateStatus/{status}',  'updateStatus')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.plants.updateStatus');

        Route::get('/admin/plants/delete/{id}', 'delete')
        ->middleware(['auth:admin', 'verified'])
        ->name('admin.plants.delete');
});

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])
    ->middleware(['auth:admin', 'verified'])
    ->name('admin.logs');