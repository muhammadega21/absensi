<?php

namespace Database\Seeders;

use App\Models\UnitKerja;
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
        User::create([
            'nip' => '040821-0001',
            'name' => 'Muhammad Ega Dermawan',
            'username' => 'Ega',
            'password' => Hash::make('password'),
            'tanggal_lahir' => '2004-08-21',
            'unit_kerja_id' => 1,
            'role' => 'admin',
            'image' => 'user.png'
        ]);
        User::create([
            'nip' => '040822-0002',
            'name' => 'Maulana Aditya',
            'username' => 'Maulana',
            'password' => Hash::make('password'),
            'tanggal_lahir' => '2004-08-22',
            'unit_kerja_id' => 2,
            'role' => 'admin',
            'image' => 'user.png'
        ]);
        User::create([
            'nip' => '040823-0003',
            'name' => 'Nola Mardiansyah Putri',
            'username' => 'Nola',
            'password' => Hash::make('password'),
            'tanggal_lahir' => '2004-08-23',
            'unit_kerja_id' => 3,
            'role' => 'karyawan',
            'image' => 'user.png'
        ]);
        User::create([
            'nip' => '040824-0004',
            'name' => 'Ofika Parsyanda',
            'username' => 'Fika',
            'password' => Hash::make('password'),
            'tanggal_lahir' => '2004-08-24',
            'unit_kerja_id' => 4,
            'role' => 'karyawan',
            'image' => 'user.png'
        ]);

        UnitKerja::create([
            'name' => 'HRD',
            'code' => 'HRD',
        ]);
        UnitKerja::create([
            'name' => 'Komunikasi',
            'code' => 'PR'
        ]);
        UnitKerja::create([
            'name' => 'Penjualan',
            'code' => 'SLS'
        ]);
        UnitKerja::create([
            'name' => 'Layanan Pelanggan',
            'code' => 'CS'
        ]);
    }
}
