<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;

Route::prefix('documents')->name('documents.')->group(function () {
  Route::get('data', [DocumentController::class, 'getData'])->name('data');
});

Route::resource('documents', DocumentController::class);
