<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Route::controller(AuthController::class)->group(function () {

//   Route::get("login", "indexLogin")->name('login');
//   Route::post("login", "login")->name('.login.post');
// });
Route::controller(AuthController::class)->name('auth')->group(function () {

  Route::get("login", "indexLogin")->name('.login.index');
  Route::get("register", "indexRegister")->name('.register.index');
  Route::get("logout", "logout")->name('.logout');

  Route::post("login", "login")->name('.login.post');
  Route::post("register", "register")->name('.register.post');
});
