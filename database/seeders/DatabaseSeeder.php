<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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

        $groups = [
            [
                'jalur' => 'Jalur Golf',
                'type' => 'Internal',
                'status' => 1
            ],
            [
                'jalur' => 'Jalur Cycle',
                'type' => 'Eksterna;',
                'status' => 1
            ],
        ];
        foreach ($groups as $group) {
            Group::create($group);
        }
    }
}
