<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin POS',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Kasir POS',
            'email' => 'kasir@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'kasir'
        ]);
    }
}
