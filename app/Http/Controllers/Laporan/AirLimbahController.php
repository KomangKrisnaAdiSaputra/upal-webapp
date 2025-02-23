<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AirLimbahController extends Controller
{
    function index()
    {
        return view("Laporan.AirLimbah.index");
    }
}
