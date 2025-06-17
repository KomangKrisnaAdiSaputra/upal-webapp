<?php

namespace App\Http\Controllers\MonitoringMinuteCounter;

use App\Http\Controllers\Controller;
use App\Models\MinuteCounter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AirLimbahController extends Controller
{
    private $enums = [];
    private $today = "";

    function __construct()
    {
        $this->enums = convertToObject([
            [
                'loop' => 4,
                'loop_datas' => ['L.75.04', 'L.75.02', 'L.75.03', null]
            ],
            [
                'loop' => 3,
                'loop_datas' => ['L.7.5.04', 'L.7.5.03', null]
            ],
            [
                'loop' => 3,
                'loop_datas' => ['L.5.5.01', 'L.7.5.02', null]
            ],
        ]);
        $this->today = Carbon::today()->toDateString();
    }

    function index()
    {
        return view("MonitoringMinuteCounter.AirLimbah.index");
    }

    function saveData(Request $request)
    {
        $keys = 10;
        DB::beginTransaction();
        try {
            $datas = collect();

            for ($i = 0; $i < $keys; $i++) {
                $datas->push(convertToObject([
                    "id" => $request->{"id_$i"},
                    "lokasi"  => $request->{"lokasi_$i"},
                    "sub_lokasi" => $request->{"sub_lokasi_$i"},
                    "pompa_terpasang" => $request->{"pompa_terpasang_$i"},
                    "jam" => $request->{"pukul_$i"},
                    "nilai" => $request->{"nilai_$i"},
                    "volume" => $request->{"volume_$i"} == "true" ? 1 : 0,
                    "ampere" => $request->{"ampere_$i"} == "true" ? 1 : 0,
                    "keterangan" => $request->{"keterangan_$i"},
                ]));
            }

            foreach ($datas as  $data) {
                if (isset($data->id) && $data->id != "") {
                    MinuteCounter::find($data->id)->update([
                        "user_id" => auth()->user()->id,
                        "jam" => $data->jam,
                        "nilai" => $data->nilai,
                        "volume" => $data->volume,
                        "ampere" => $data->ampere,
                        "keterangan" => $data->keterangan,
                        "tanggal" => $request->date_filter ?? $this->today,
                    ]);
                } else {
                    MinuteCounter::create([
                        "user_id" => auth()->user()->id,
                        "type" => MinuteCounter::TYPE_AIR_LIMBAH,
                        "lokasi"  => $data->lokasi,
                        "sub_lokasi" => $data->sub_lokasi,
                        "pompa_terpasang" => $data->pompa_terpasang,
                        "jam" => $data->jam,
                        "nilai" => $data->nilai,
                        "volume" => $data->volume,
                        "ampere" => $data->ampere,
                        "keterangan" => $data->keterangan,
                        "tanggal" => $request->date_filter ?? $this->today,
                    ]);
                }
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([], 500);
        }

        return response()->json([], 200);
    }

    function getTabel(Request $request)
    {
        $date = $request->date ?? $this->today;
        $yesterday = Carbon::parse($date)->subDay()->toDateString();

        $air_limbah_datas = MinuteCounter::with(["user"])->where("type", MinuteCounter::TYPE_AIR_LIMBAH)
            ->where("tanggal", $date)->get();

        $air_limbah_olds = MinuteCounter::with(["user"])->where("type", MinuteCounter::TYPE_AIR_LIMBAH)
            ->where("tanggal", $yesterday)->get();

        $datas = collect();

        if ($air_limbah_datas->count() > 0) {
            foreach ($air_limbah_datas as $al_data) {
                $old = $air_limbah_olds->where("lokasi", $al_data->lokasi)
                    ->where("sub_lokasi", $al_data->sub_lokasi)
                    ->where("pompa_terpasang", $al_data->pompa_terpasang)
                    ->first();

                $datas->push(convertToObject([
                    'id' => $al_data->id,
                    'lokasi' => $al_data->lokasi,
                    'sub_lokasi' => $al_data->sub_lokasi,
                    'pompa_terpasang' => $al_data->pompa_terpasang,
                    'pukul' => $al_data->jam,
                    'nilai_terakhir' => $al_data->nilai,
                    'nilai_sebelumnya' => $old?->nilai ?? "",
                    'volume' => $al_data->volume,
                    'ampere' => $al_data->ampere,
                    'user' => $al_data->user?->nama ?? "",
                    'keterangan' => $al_data->keterangan,
                ]));
            }
        } else {
            foreach ($this->enums as $key => $enum) {
                for ($i = 0; $i < $enum->loop; $i++) {
                    $lokasi = "LPS " . $key + 1;
                    $sub_lokasi = "Pompa " . $i + 1;
                    $pompa_terpasang = $enum->loop_datas[$i];

                    $old = $air_limbah_olds->where("lokasi", $lokasi)
                        ->where("sub_lokasi", $sub_lokasi)
                        ->where("pompa_terpasang", $pompa_terpasang)
                        ->first();

                    $datas->push(convertToObject([
                        'lokasi' => $lokasi,
                        'sub_lokasi' => $sub_lokasi,
                        'pompa_terpasang' => $pompa_terpasang,
                        'pukul' => "",
                        'nilai_terakhir' => "",
                        'nilai_sebelumnya' => $old?->nilai ?? "",
                        'volume' => true,
                        'ampere' => true,
                        'user' => null,
                        'keterangan' => null,
                    ]));
                }
            }
        }

        return view("MonitoringMinuteCounter.AirLimbah.Partials.tabel", compact('datas'));
    }
}
