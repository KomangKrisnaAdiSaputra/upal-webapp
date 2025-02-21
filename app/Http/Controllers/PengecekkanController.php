<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Utilitas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengecekkanController extends Controller
{
    function index()
    {
        return view("Pengecekkan.index");
    }

    function getTabel(Request $request)
    {
        $tanggal = $request->tanggal ?? Carbon::today()->toDateString();
        $datas = Utilitas::where('id_user', auth()->user()->id)->where('tanggal', $tanggal)->get();

        return view("Pengecekkan.Partials.tabel", compact('datas'));
    }

    function create()
    {
        $customers = $this->customers();
        $jenis = $this->jenis();
        $satuan = $this->satuan();
        return view("Pengecekkan.Form.index", compact('customers', 'jenis', 'satuan'));
    }

    function edit(Request $request, $id)
    {
        return view("Pengecekkan.Form.index");
    }

    function saveData(Request $request)
    {
        DB::beginTransaction();
        try {
            $data_cek = [
                'id_customer' => $request->id_customer,
                'id_user' => auth()->user()->id,
                'jenis' => $request->jenis,
                'satuan' => $request->satuan,
                'tanggal' => Carbon::today()->toDateString(),
                'nilai' => $request->nilai,
                'status' => Utilitas::STATUS_MENUNGGU
            ];

            if (isset($request->id) && $request->id) {
                $utilitas = Utilitas::find($request->id);
                $utilitas->update($data_cek);
            } else {
                Utilitas::create($data_cek);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $route = isset($request->id) && $request->id ? 'pengecekkan.edit.index' : 'pengecekkan.create.index';
            return redirect()->route($route);
        }
        return redirect()->route('pengecekkan');
    }

    function customers()
    {
        return Customer::selectRaw("id as value, nama as label")->where("status", 1)->get();
    }

    function jenis()
    {
        return [
            [
                'label' => "Air Limbah",
                'value' => "air_limbah"
            ],
            [
                'label' => "Air Irigasi",
                'value' => "air_irigasi"
            ],
        ];
    }

    function satuan()
    {
        return [
            [
                'label' => "m3",
                'value' => "m3"
            ],
            [
                'label' => "kWh",
                'value' => "khw"
            ],
        ];
    }
}
