<?php

use App\Http\Controllers\DasboardController;
use App\Http\Controllers\Master\UserManagerController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

  Route::controller(DasboardController::class)->group(function () {
    Route::get("dashboard", "index")->name('dashboard.index');
  });

  Route::prefix("master")->name("master")->group(function () {

    Route::prefix("usermanager")->name(".usermanager")->controller(UserManagerController::class)->group(function () {
      Route::get("/", "index");
      Route::get("create", "create")->name('.create.index');
      Route::get("edit/{id}", "edit")->name('.edit.index');
      Route::post("savedata", "saveData")->name('.savedata.post');
    });
  });
});
