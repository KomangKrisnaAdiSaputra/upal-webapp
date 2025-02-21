<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Customer;
use App\Models\Group;
use App\Models\User;
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
    }
}
