<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;

Route::prefix('services')->name('services.')->group(function () {
  Route::get('data', [ServiceController::class, 'getData'])->name('data');
});

Route::resource('services', ServiceController::class);
