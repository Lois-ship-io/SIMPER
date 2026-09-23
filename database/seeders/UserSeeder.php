<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@simper.test',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        $pustakawan = User::create([
            'name' => 'Pustakawan',
            'email' => 'pustakawan@simper.test',
            'password' => Hash::make('password'),
            'phone' => '081234567891',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $pustakawan->assignRole('pustakawan');
    }
}
