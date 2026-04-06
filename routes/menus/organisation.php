<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganisationController;

Route::prefix('organisations')->name('organisations.')->group(function () {
  Route::get('data', [OrganisationController::class, 'getData'])->name('data');
  Route::get('count', [OrganisationController::class, 'count'])->name('count');
});

Route::resource('organisations', OrganisationController::class);
