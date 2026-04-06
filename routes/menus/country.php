<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;

Route::prefix('areas-region')->name('countries.')->group(function () {
  Route::get('data', [CountryController::class, 'getData'])->name('data');
});

Route::resource('areas-region', CountryController::class);
