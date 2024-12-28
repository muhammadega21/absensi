<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Muhammad Ega Dermawan',
            'username' => 'Ega',
            'email' => 'dermawane988@gmail.com',
            'password' => Hash::make('password'),
            'qr_code' => Str::uuid(),
            'jabatan_id' => 1,
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'Maulana Aditya',
            'username' => 'Maulana',
            'email' => 'maulana123@gmail.com',
            'password' => Hash::make('password'),
            'qr_code' => Str::uuid(),
            'jabatan_id' => 2,
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'Nola Mardiansyah Putri',
            'username' => 'Nola',
            'email' => 'nola123@gmail.com',
            'password' => Hash::make('password'),
            'qr_code' => Str::uuid(),
            'jabatan_id' => 3,
            'role' => 'karyawan'
        ]);
        User::create([
            'name' => 'Ofika Parsyanda',
            'username' => 'Fika',
            'email' => 'ofika123@gmail.com',
            'password' => Hash::make('password'),
            'qr_code' => Str::uuid(),
            'jabatan_id' => 3,
            'role' => 'karyawan'
        ]);

        Jabatan::create([
            'name' => 'Direktur'
        ]);
        Jabatan::create([
            'name' => 'Wakil Direktur'
        ]);
        Jabatan::create([
            'name' => 'Kasir'
        ]);
    }
}
