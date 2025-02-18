<?php

use App\Http\Controllers\DasboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

  Route::controller(DasboardController::class)->group(function () {

    Route::get("dashboard", "index")->name('dashboard.index');
  });
});
