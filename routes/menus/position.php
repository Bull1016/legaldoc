<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PositionController;

Route::prefix('positions')->name('positions.')->group(function () {
  Route::get('data', [PositionController::class, 'getData'])->name('data');
});

Route::prefix('permissions')->name('permissions.')->group(function () {
  Route::get('index', [PositionController::class, 'indexPermission'])->name('indexPermission');
  Route::get('position/{position}', [PositionController::class, 'getPositionPermissions'])->name('getPositionPermissions');
  Route::put('update/{position}', [PositionController::class, 'updatePermission'])->name('updatePermission');
});

Route::resource('positions', PositionController::class);
