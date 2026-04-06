<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;

Route::prefix('members')->name('members.')->group(function () {
  Route::get('data', [MemberController::class, 'getData'])->name('data');
});

Route::resource('members', MemberController::class);
