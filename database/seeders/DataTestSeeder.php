<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Group;
use App\Models\MinuteCounter;
use App\Models\User;
use App\Models\Utilitas;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DataTestSeeder extends Seeder
{
  function run()
  {
    // Minute Air Limbah 
    for ($i = 1; $i <= 10; $i++) {
      $dates[] = Carbon::now()->subDays($i)->toDateString();
    }
    $enums = convertToObject([
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
    foreach ($dates as $date) {
      foreach ($enums as $key => $enum) {
        for ($i = 0; $i < $enum->loop; $i++) {
          $lokasi = "LPS " . $key + 1;
          MinuteCounter::create([
            'type' => MinuteCounter::TYPE_AIR_LIMBAH,
            'lokasi' => $lokasi,
            'sub_lokasi' => "Pompa " . $i + 1,
            'pompa_terpasang' => $enum->loop_datas[$i],
            'jam' => "06:30",
            'nilai' => number_format(mt_rand(1000, 9999) + mt_rand(0, 99) / 100, 2, '.', ''),
            'volume' => true,
            'ampere' => true,
            'tanggal' => $date
          ]);
        }
      }
    }
    // End Minute Air Limbah

    // Minute Air Irigasi
    $enums = convertToObject([
      [
        'loop' => 4,
        'loop_datas' => ['RG.01', 'RG.02', null, null]
      ],
      [
        'loop' => 3,
        'loop_datas' => ['RS.01', 'RS.2', null]
      ],
    ]);
    foreach ($dates as $date) {
      foreach ($enums as $key => $enum) {
        for ($i = 0; $i < $enum->loop; $i++) {
          $lokasi = $key > 0 ? "POMPA ST. REGIS" : "POMPA GOLF";
          MinuteCounter::create([
            'type' => MinuteCounter::TYPE_AIR_IRIGASI,
            'lokasi' => $lokasi,
            'sub_lokasi' => "Pompa " . $i + 1,
            'pompa_terpasang' => $enum->loop_datas[$i],
            'jam' => "06:30",
            'nilai' => number_format(100000 / 100, 2, '.', ''),
            'volume' => true,
            'ampere' => true,
            'tanggal' => $date
          ]);
        }
      }
    }
    // End Minute Air Irigasi

    // Pengecekkan Air Limbah
    $month = Carbon::now()->startOfMonth()->isoFormat("M");
    $firstDayOfMonth = Carbon::now()->month($month)->startOfMonth();
    for ($i = 0; $i < ((int)$month - 1); $i++) {
      $tanggal = $firstDayOfMonth->addMonths(-1)->toDateString();
      foreach (Customer::where("air_limbah", 1)->get() as $key => $_customer) {
        // $previousUtilitas = Utilitas::where('customer_id', $_customer->id)
        //     ->where("type", Utilitas::TYPE_AIR_LIMBAH)
        //     ->where('tanggal', '<', $tanggal)
        //     ->orderBy('tanggal', 'desc')
        //     ->first();

        // $minNilai = $previousUtilitas?->nilai ?? 1000;

        // do {
        //     $nilai = mt_rand(1000, 9999);
        // } while ($nilai < $minNilai);
        $nilai = 10000;

        Utilitas::create([
          'customer_id' => $_customer->id,
          'user_id' => User::where("username", "manajement")->first()?->id ?? null,
          'nilai' => $nilai,
          'type' => Utilitas::TYPE_AIR_LIMBAH,
          // 'status' => Utilitas::STATUS_MENUNGGU,
          'tanggal' => $tanggal
        ]);
      }
    }
    // End Pengecekkan Air Limbah

    // Pengecekkan Air Irigasi
    $loop = 30;
    $today = Carbon::today()->toDateString();
    for ($i = 1; $i < $loop; $i++) {
      $tanggal = Carbon::parse($today)->addDays("-$i")->toDateString();
      foreach (Customer::where("air_irigasi", 1)->get() as $key => $_customer) {
        // $previousUtilitas = Utilitas::where('customer_id', $_customer->id)
        //     ->where("type", Utilitas::TYPE_AIR_IRIGASI)
        //     ->where('tanggal', '<', $tanggal)
        //     ->orderBy('tanggal', 'desc')
        //     ->first();

        // $minNilai = $previousUtilitas?->nilai ?? 1000;
        // $nilai = max(mt_rand(1000, 9999), $minNilai);

        $nilai = 10000;

        Utilitas::create([
          'customer_id' => $_customer->id,
          'user_id' => User::where("username", "manajement")->first()?->id ?? null,
          'nilai' => $nilai,
          'type' => Utilitas::TYPE_AIR_IRIGASI,
          // 'status' => Utilitas::STATUS_MENUNGGU,
          'keterangan' => null,
          'tanggal' => $tanggal
        ]);
      }
    }
    // End Pengecekkan Air Irigasi
  }
}
