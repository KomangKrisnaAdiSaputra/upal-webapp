<?php

namespace App\Http\Controllers;

use App\Models\Utilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DasboardController extends Controller
{
    function index()
    {
        $years = Utilitas::select(DB::raw('YEAR(tanggal) as tahun'))
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');
        return view("Dashboard.index", compact("years"));
    }

    public function getChartData(Request $request)
    {
        $year = $request->query('tahun', date('Y'));

        $results = Utilitas::select(
            DB::raw('MONTH(tanggal) as bulan'),
            'type',
            DB::raw('SUM(nilai) as total')
        )
            ->whereYear('tanggal', $year)
            ->groupBy('bulan', 'type')
            ->orderBy('bulan')
            ->get();

        $limbah = array_fill(1, 12, 0);   // bulan 1–12
        $irigasi = array_fill(1, 12, 0);  // bulan 1–12

        foreach ($results as $row) {
            if ($row->type === 'AIR_LIMBAH') {
                $limbah[(int)$row->bulan] = (float)$row->total;
            } elseif ($row->type === 'AIR_IRIGASI') {
                $irigasi[(int)$row->bulan] = (float)$row->total;
            }
        }

        return response()->json([
            'limbah' => array_values($limbah),
            'irigasi' => array_values($irigasi),
        ]);
    }
}
