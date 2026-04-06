<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::prefix('users')->name('users.')->group(function () {
  Route::get('data', [UserController::class, 'getData'])->name('data');
});

Route::resource('users', UserController::class);
