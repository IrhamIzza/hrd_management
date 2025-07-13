<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    \App\Models\User::create([
        'name' => 'HRD Admin',
        'username' => 'hrd_admin',
        'email' => 'hrd@example.com',
        'password' => bcrypt('password'),
        'role' => 'hrd',
        'phone' => '085850180285',
        'address' => 'Bumi Palapa, Malang',
    ]);

    \App\Models\User::create([
        'name' => 'Adinda Rahajeng',
        'username' => 'adinda',
        'email' => 'adinda@example.com',
        'password' => bcrypt('password'),
        'role' => 'karyawan',
        'phone' => '081298765432',
        'address' => 'Jl. Patimura, Malang',
    ]);
}

}
