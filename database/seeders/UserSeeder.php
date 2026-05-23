<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@toko.com',
            'password' => 'password',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Toko Elektronik Jaya',
            'email' => 'seller@toko.com',
            'password' => 'password',
            'role' => 'seller',
        ]);

        User::create([
            'name' => 'Toko Fashion Keren',
            'email' => 'seller2@toko.com',
            'password' => 'password',
            'role' => 'seller',
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'buyer@toko.com',
            'password' => 'password',
            'role' => 'buyer',
        ]);

        User::create([
            'name' => 'Siti Rahma',
            'email' => 'buyer2@toko.com',
            'password' => 'password',
            'role' => 'buyer',
        ]);
    }
}