<?php

namespace App\Http\Controllers\Pengecekkan;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Utilitas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AirLimbahController extends Controller
{
    function index()
    {
        return view("Pengecekkan.AirLimbah.index");
    }

    function getTabel(Request $request)
    {
        $date = $request->date ?? Carbon::now()->startOfMonth();
        $datas = Utilitas::where("type", Utilitas::TYPE_AIR_LIMBAH)->whereDate("tanggal", $date)->get();
        return view("Pengecekkan.AirLimbah.Partials.tabel", compact('datas'));
    }

    function form(Request $request)
    {
        $customers = Customer::with(['group', 'utilitas' => function ($utilitas) {
            $utilitas->where("type", Utilitas::TYPE_AIR_LIMBAH)->whereDate("tanggal", Carbon::now()->startOfMonth());
        }])->where("status", 1)->get();

        $data = Utilitas::find($request->id);
        return view("Pengecekkan.AirLimbah.Form.index", compact('customers', 'data'));
    }

    function saveData(Request $request)
    {
        DB::beginTransaction();
        try {
            if (isset($request->id) && $request->id != "") {
                $utilitas = Utilitas::find($request->id);
                $utilitas->update([
                    'user_id' => auth()->user()->id,
                    'nilai' => (float)$request->nilai,
                ]);
            } else {
                $utilitas = Utilitas::create([
                    'customer_id' => $request->customer_id,
                    'user_id' => auth()->user()->id,
                    'nilai' => (float)$request->nilai,
                    'type' => Utilitas::TYPE_AIR_LIMBAH,
                    // 'status' => Utilitas::STATUS_MENUNGGU,
                    'tanggal' => Carbon::now()->startOfMonth()->toDateString()
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
