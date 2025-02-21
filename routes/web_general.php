<?php

use App\Http\Controllers\DasboardController;
use App\Http\Controllers\Master\CustomerController;
use App\Http\Controllers\Master\GroupController;
use App\Http\Controllers\Master\UserManagerController;
use App\Http\Controllers\PencatatanMinuteCounter\AirIrigasiController;
use App\Http\Controllers\PencatatanMinuteCounter\AirLimbahController;
use App\Http\Controllers\PengecekkanController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

  Route::controller(DasboardController::class)->group(function () {
    Route::get("dashboard", "index")->name('dashboard.index');
  });

  Route::prefix('pengecekkan')->name('pengecekkan')->controller(PengecekkanController::class)->group(function () {
    Route::get("/", "index");
    Route::get("gettabel", "getTabel")->name('.gettabel');
    Route::get("create", "create")->name('.create.index');
    Route::get("edit/{id}", "edit")->name('.edit.index');
    Route::post("savedata", "saveData")->name('.savedata.post');
  });

  Route::prefix('pencatatan/mc')->name('pencatatan.mc')->controller(PengecekkanController::class)->group(function () {

    Route::prefix("airlimbah")->name(".airlimbah")->controller(AirLimbahController::class)->group((function () {
      Route::get("/", "index");
    }));

    Route::prefix("airirigasi")->name(".airirigasi")->controller(AirIrigasiController::class)->group((function () {
      Route::get("/", "index");
    }));
  });

  Route::prefix("master")->name("master")->group(function () {

    Route::prefix("group")->name(".group")->controller(GroupController::class)->group(function () {
      Route::get("/", "index");
      Route::get("create", "create")->name('.create.index');
      Route::get("edit/{id}", "edit")->name('.edit.index');
      Route::post("savedata", "saveData")->name('.savedata.post');
    });

    Route::prefix("customer")->name(".customer")->controller(CustomerController::class)->group(function () {
      Route::get("/", "index");
      Route::get("create", "create")->name('.create.index');
      Route::get("edit/{id}", "edit")->name('.edit.index');
      Route::post("savedata", "saveData")->name('.savedata.post');
    });

    Route::prefix("usermanager")->name(".usermanager")->controller(UserManagerController::class)->group(function () {
      Route::get("/", "index");
      Route::get("create", "create")->name('.create.index');
      Route::get("edit/{id}", "edit")->name('.edit.index');
      Route::post("savedata", "saveData")->name('.savedata.post');
    });
  });
});
