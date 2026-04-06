<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;

use App\Http\Controllers\authentications\Login;
use App\Http\Controllers\authentications\Register;
use App\Http\Controllers\authentications\ForgotPassword;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\FrontController;

Route::get('/lang/{locale}', [LanguageController::class, 'swap'])->name('lang.swap');
Route::get('/lang2/{locale}', [LanguageController::class, 'swap'])->name('language.change');

// GUEST
Route::get('/', [FrontController::class, 'index'])->name('home');

Route::prefix('auth')->group(function () {
  Route::get('/register', [Register::class, 'index'])->name('register');
  Route::post('/register/store', [Register::class, 'store'])->name('register.store');
  Route::get('/login', [Login::class, 'login'])->name('login');
  Route::post('/login/store', [Login::class, 'loginStore'])->name('login.store');

  Route::get('/forgot-password', [ForgotPassword::class, 'index'])->name('reset_password');
  Route::post('/forgot-password/store', [ForgotPassword::class, 'store'])->name('reset_password.store');
});

// AUTH
Route::middleware('auth')->group(function () {
  Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');

  require __DIR__ . '/menus/organisation.php';
  require __DIR__ . '/menus/members.php';
  require __DIR__ . '/menus/documents.php';
  require __DIR__ . '/menus/my-requests.php';
  require __DIR__ . '/menus/country.php';
  require __DIR__ . '/menus/town.php';
  require __DIR__ . '/menus/users.php';
  require __DIR__ . '/menus/partners.php';
  require __DIR__ . '/menus/position.php';

  Route::post('/auth/logout', [Login::class, 'logout'])->name('logout');
});
