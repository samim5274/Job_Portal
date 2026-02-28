<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 2 Admin
        User::updateOrCreate(
            ['email' => 'admin1@gmail.com'],
            [
                'name' => 'Admin One',
                'password' => Hash::make('123456789'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin2@gmail.com'],
            [
                'name' => 'Admin Two',
                'password' => Hash::make('123456789'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // 8 Users
        for ($i = 1; $i <= 8; $i++) {
            User::updateOrCreate(
                ['email' => "user{$i}@gmail.com"],
                [
                    'name' => "User {$i}",
                    'password' => Hash::make('123456789'),
                    'role' => 'user',
                    'is_active' => true,
                ]
            );
        }
    }
}
