<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AirIrigasiController extends Controller
{
    function index()
    {
        return view("Laporan.AirIrigasi.index");
    }

    function getTabel()
    {
        $datas = [];
        return view("Laporan.Partials.tabel", compact('datas'));
    }
}
