<?php

use App\Http\Controllers\DasboardController;
use App\Http\Controllers\Laporan\AirLimbahController as LaporanAirLimbahController;
use App\Http\Controllers\Laporan\AirIrigasiController as LaporanAirIrigasiController;
use App\Http\Controllers\Master\CustomerController;
use App\Http\Controllers\Master\GroupController;
use App\Http\Controllers\Master\UserManagerController;
use App\Http\Controllers\PencatatanMinuteCounter\AirIrigasiController;
use App\Http\Controllers\PencatatanMinuteCounter\AirLimbahController;
use App\Http\Controllers\Pengecekkan\AirIrigasiController as PengecekkanAirIrigasiController;
use App\Http\Controllers\Pengecekkan\AirLimbahController as PengecekkanAirLimbahController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

  Route::controller(DasboardController::class)->group(function () {
    Route::get("dashboard", "index")->name('dashboard.index');
  });

  Route::controller(ProfileController::class)->group(function () {
    Route::get("profile", "index")->name('profile.index');
    Route::post("save", "save")->name('profile.save.post');
  });

  // Route::prefix('laporan')->name('laporan')->group(function () {

  //   Route::prefix("airlimbah")->name(".airlimbah")->controller(LaporanAirLimbahController::class)->group(function () {
  //     Route::get("/", "index");
  //     Route::get("gettabel", "getTabel")->name('.gettabel');
  //     Route::get("form", "form")->name('.form');
  //     Route::post("savedata", "saveData")->name('.savedata.post');
  //   });

  //   Route::prefix("airirigasi")->name(".airirigasi")->controller(LaporanAirIrigasiController::class)->group(function () {
  //     Route::get("/", "index");
  //     Route::get("gettabel", "getTabel")->name('.gettabel');
  //     Route::get("form", "form")->name('.form');
  //     Route::post("savedata", "saveData")->name('.savedata.post');
  //   });
  // });

  Route::prefix('pengecekkan')->name('pengecekkan')->group(function () {

    Route::prefix("airlimbah")->name(".airlimbah")->controller(PengecekkanAirLimbahController::class)->group(function () {
      Route::get("/", "index");
      Route::get("gettabel", "getTabel")->name('.gettabel');
      Route::get("form", "form")->name('.form');
      Route::post("savedata", "saveData")->name('.savedata.post');
    });

    Route::prefix("airirigasi")->name(".airirigasi")->controller(PengecekkanAirIrigasiController::class)->group(function () {
      Route::get("/", "index");
      Route::get("gettabel", "getTabel")->name('.gettabel');
      Route::get("form", "form")->name('.form');
      Route::get("pdf/{date}", "pdf")->name('.pdf');
      Route::post("savedata", "saveData")->name('.savedata.post');
    });
  });

  Route::prefix('pencatatan/mc')->name('pencatatan.mc')->group(function () {

    Route::prefix("airlimbah")->name(".airlimbah")->controller(AirLimbahController::class)->group((function () {
      Route::get("/", "index");
      Route::get("gettabel", "getTabel")->name('.gettabel');
      Route::post("savedata", "saveData")->name('.savedata.post');
    }));

    Route::prefix("airirigasi")->name(".airirigasi")->controller(AirIrigasiController::class)->group((function () {
      Route::get("/", "index");
      Route::get("gettabel", "getTabel")->name('.gettabel');
      Route::post("savedata", "saveData")->name('.savedata.post');
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
