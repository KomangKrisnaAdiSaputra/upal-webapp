<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Customer;
use App\Models\Group;
use App\Models\MinuteCounter;
use App\Models\User;
use App\Models\Utilitas;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Create User
        $users = [
            [
                'nama' => 'Manajement',
                'username' => 'manajement',
                'email' => 'manajement@gmail.com',
                'password' => Hash::make('testingPass'),
                'role' => 1
            ],
            [
                'nama' => 'Staff',
                'username' => 'staff',
                'email' => 'staff@gmail.com',
                'password' => Hash::make('testingPass'),
                'role' => 2
            ],
        ];
        foreach ($users as $user) {
            User::create($user);
        }
        // End Create User

        // Group
        $groups = [
            [
                'jalur' => 'Jalur Golf',
                'type' => 'Internal',
                'status' => 1
            ],
            [
                'jalur' => 'Jalur Cycle',
                'type' => 'Eksternal',
                'status' => 1
            ],
        ];
        foreach ($groups as $group) {
            Group::create($group);
        }
        // End Group

        // Customer
        $qty_customer = 10;
        $_groups = Group::get();
        $PAL = [
            "70% X PEMAK AIR BERSIH",
            "1.5 X RNS",
            null
        ];
        for ($cus = 0; $cus < $qty_customer; $cus++) {
            $group_id = $cus > 4 ? $_groups->first()->id : $_groups->last()->id;
            Customer::create([
                'group_id' => $group_id,
                'nama' => "Customer " . $cus + 1,
                'air_irigasi' => $cus == 0 ? 0 : 1,
                'harga_air_irigasi' => $cus == 0 ? null : 8192.8,
                'air_limbah' => $cus == 1 ? 0 : 1,
                'harga_air_limbah' => $cus == 1 ? null : 4158.5,
                'penanganan_air_limbah' => $PAL[array_rand($PAL)],
                'status' => 1
            ]);
        }
        // End Customer

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
                        'nilai' => number_format(mt_rand(1000, 9999) + mt_rand(0, 99) / 100, 2, '.', ''),
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
            foreach (Customer::get() as $key => $_customer) {
                Utilitas::create([
                    'customer_id' => $_customer->id,
                    'user_id' => User::where("username", "manajement")->first()?->id ?? null,
                    'nilai' => mt_rand(1000, 9999),
                    'type' => Utilitas::TYPE_AIR_LIMBAH,
                    'status' => Utilitas::STATUS_MENUNGGU,
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
            foreach (Customer::get() as $key => $_customer) {
                Utilitas::create([
                    'customer_id' => $_customer->id,
                    'user_id' => User::where("username", "manajement")->first()?->id ?? null,
                    'nilai' => mt_rand(1000, 9999),
                    'type' => Utilitas::TYPE_AIR_IRIGASI,
                    'status' => Utilitas::STATUS_MENUNGGU,
                    'keterangan' => null,
                    'tanggal' => $tanggal
                ]);
            }
        }
        // End Pengecekkan Air Irigasi
    }
}
