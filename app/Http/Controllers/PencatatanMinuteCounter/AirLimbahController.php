<?php

namespace App\Http\Controllers\PencatatanMinuteCounter;

use App\Http\Controllers\Controller;
use App\Models\MinuteCounter;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AirLimbahController extends Controller
{
    private $enums = [];

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
    }

    function index()
    {
        $today = Carbon::today()->toDateString();
        $air_limbah_datas = MinuteCounter::where("type", MinuteCounter::TYPE_AIR_LIMBAH)
            ->where("user_id", auth()->user()->id)->where("tanggal", $today)->get();

        $datas = collect();
        foreach ($this->enums as $key => $enum) {
            for ($i = 0; $i < $enum->loop; $i++) {
                $lokasi = "LPS " . $key + 1;
                $datas->push([
                    'lokasi' => $lokasi,
                    'sub_lokasi' => "Pompa " . $i + 1,
                    'pompa_terpasang' => $enum->loop_datas[$i],
                    'pukul' => "",
                    'nilai_terakhir' => "",
                    'nilai_sebelumnya' => "",
                    'volume' => null,
                    'ampere' => null,
                    'user' => null,
                    'keterangan' => null,
                ]);
            }
        }
        $datas = convertToObject($datas);
        return view("PencatatanMinuteCounter.AirLimbah.index", compact('datas'));
    }
}
