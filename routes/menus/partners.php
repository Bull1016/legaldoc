<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartnerController;

Route::prefix('partners')->name('partners.')->group(function () {
  Route::get('data', [PartnerController::class, 'getData'])->name('data');
});

Route::resource('partners', PartnerController::class);
