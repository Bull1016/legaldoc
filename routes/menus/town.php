<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TownController;

Route::prefix('towns')->name('towns.')->group(function () {
  Route::get('data/{area}', [TownController::class, 'getData'])->name('data');

  Route::post('{area}/store', [TownController::class, 'store'])->name('store');
  Route::put('{area}/update/{region}', [TownController::class, 'update'])->name('update');
  Route::delete('{area}/destroy/{region}', [TownController::class, 'destroy'])->name('destroy');
});
