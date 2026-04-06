<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MyRequestController;

Route::prefix('my-requests')->name('my-requests.')->group(function () {
  Route::get('data', [MyRequestController::class, 'getData'])->name('data');
});

Route::resource('my-requests', MyRequestController::class);
