<?php

namespace App\Http\Controllers\Pengecekkan;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Group;
use App\Models\Utilitas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AirIrigasiController extends Controller
{
    function index()
    {
        return view("Pengecekkan.AirIrigasi.index");
    }

    function getTabel(Request $request)
    {
        $date = $request->date ?? Carbon::today()->toDateString();
        $yesterday = Carbon::parse($date)->subDay()->toDateString();

        $datas = collect();
        $utilitas = Utilitas::with(['user', 'customer'])->where("type", Utilitas::TYPE_AIR_IRIGASI)->where("tanggal", $date)->get();
        $utilitas_old = Utilitas::with(['user', 'customer'])->where("type", Utilitas::TYPE_AIR_IRIGASI)->where("tanggal", $yesterday)->get();

        foreach ($utilitas as $_utilitas) {
            $_old = $utilitas_old->where("user_id", $_utilitas->user_id)->first();
            $nilai = $_utilitas->nilai;
            $nilai_sebelumnya = $_old?->nilai ?? 0;
            $datas->push(convertToObject([
                'id' => $_utilitas->id,
                'konsumen' => $_utilitas->customer->nama,
                'nilai_terakhir' => $nilai,
                'nilai_sebelumnya' => $nilai_sebelumnya,
                'pemakaian' => $nilai - $nilai_sebelumnya,
                'keterangan' => $_utilitas->keterangan,
                'user' => $_utilitas->user->nama,
            ]));
        }

        return view("Pengecekkan.AirIrigasi.Partials.tabel", compact('datas'));
    }

    function pdf(Request $request, $date)
    {
        $yesterday = Carbon::parse($date)->subDay()->toDateString();
        $firstdate = Carbon::parse($date)->startOfMonth()->toDateString();
        dd($firstdate);
        $datas = collect();
        $total_data = collect();
        $groups = Group::where("status", 1)->get();

        foreach ($groups as $group) {
            $_datas = collect();
            $_utilitas = $this->getUtilitas($date, $yesterday, $group->id);
            $utilitas = $_utilitas->where("tanggal", $date)->values();

            foreach ($utilitas as $val) {
                $old = $_utilitas->where("user_id", $val->user_id)->where("tanggal", $yesterday)->first();
                $nilai_terakhir = $val->nilai;
                $nilai_sebelumnya = $old?->nilai ?? 0;

                $_datas->push(convertToObject([
                    'id' => $val->id,
                    'old_id' => $old?->id ?? null,
                    'customer' => $val?->customer?->nama ?? "",
                    'nilai_terakhir' => $nilai_terakhir,
                    'nilai_sebelumnya' => $nilai_sebelumnya,
                    'pemakaian' => $nilai_terakhir - $nilai_sebelumnya,
                    'keterangan' => $val->keterangan,
                    'user' => $val?->user?->nama ?? ""
                ]));
            }
            $datas->push(convertToObject([
                'id' => $group->id,
                'jalur' => $group->jalur,
                'type' => $group->type,
                'datas' => $_datas
            ]));
        }

        dd($datas);
    }

    function getUtilitas($date, $old_date, $group_id)
    {

        return Utilitas::with(['customer', 'user'])->where('type', Utilitas::TYPE_AIR_IRIGASI)
            ->whereBetween('tanggal', [$old_date, $date])
            ->whereHas('customer', function ($customer) use ($group_id) {
                $customer->where("status", 1)->where("air_irigasi", 1)->where("group_id", $group_id);
            })->get();
    }

    function form(Request $request)
    {
        $date = Carbon::today()->toDateString();
        $yesterday = Carbon::parse($date)->subDay()->toDateString();

        $customers = Customer::with(['group', 'utilitas' => function ($utilitas) use ($date, $yesterday) {
            $utilitas->where("type", Utilitas::TYPE_AIR_IRIGASI)->whereIn("tanggal", [$date, $yesterday]);
        }])->where("air_irigasi", 1)->where("status", 1)->get();

        $data = Utilitas::find($request->id);
        $old = Utilitas::where("customer_id", $data?->customer_id)
            ->where("type", Utilitas::TYPE_AIR_IRIGASI)
            ->where("tanggal", Carbon::parse($data?->tanggal)->subDay()->toDateString())->first();
        return view("Pengecekkan.AirIrigasi.Form.index", compact('customers', 'data', 'old'));
    }

    function saveData(Request $request)
    {
        DB::beginTransaction();
        try {
            if (isset($request->id) && $request->id != "") {
                $utilitas = Utilitas::find($request->id);
                $utilitas->update([
                    'user_id' => auth()->user()->id,
                    'nilai' => (float)$request->nilai_terakhir,
                ]);
            } else {
                $utilitas = Utilitas::create([
                    'customer_id' => $request->customer_id,
                    'user_id' => auth()->user()->id,
                    'nilai' => (float)$request->nilai_terakhir,
                    'type' => Utilitas::TYPE_AIR_IRIGASI,
                    'status' => Utilitas::STATUS_MENUNGGU,
                    'keterangan' => $request->keterangan,
                    'tanggal' => Carbon::today()->toDateString()
                ]);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([], 500);
        }

        return response()->json(['id' => $utilitas->id], 200);
    }
}
