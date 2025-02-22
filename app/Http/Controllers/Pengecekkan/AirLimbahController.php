<?php

namespace App\Http\Controllers\Pengecekkan;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class AirLimbahController extends Controller
{
    function index()
    {
        return view("Pengecekkan.AirLimbah.index");
    }

    function getTabel(Request $request)
    {
        return view("Pengecekkan.AirLimbah.Partials.tabel");
    }

    function form(Request $request)
    {
        $customers = Customer::where("status", 1)->get();
        dd($customers->toArray());
        return view("Pengecekkan.AirLimbah.Form.index", compact('customers'));
    }
}
