<?php

namespace Database\Seeders;

use App\Models\Absen;
use App\Models\AbsenMasuk;
use App\Models\AbsenPulang;
use App\Models\UnitKerja;
use App\Models\User;
use Carbon\Carbon;
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
        $user = [
            [
                'nip' => '010629-0001',
                'name' => 'Tata Afifah Putri Lubis',
                'username' => 'Afifah',
                'password' => Hash::make('password'),
                'tanggal_lahir' => '2001-06-29',
                'unit_kerja_id' => 2,
                'role' => 'admin',
                'image' => 'user.png'
            ],
            [
                'nip' => '010601-0002',
                'name' => 'Sonia Rahmadani',
                'username' => 'Sonia',
                'password' => Hash::make('password'),
                'tanggal_lahir' => '2001-06-01',
                'unit_kerja_id' => 1,
                'role' => 'admin',
                'image' => 'user.png'
            ],
            [
                'nip' => '030216-0003',
                'name' => 'Bintang Februhaji',
                'username' => 'Bintang',
                'password' => Hash::make('password'),
                'tanggal_lahir' => '2003-02-06',
                'unit_kerja_id' => 3,
                'role' => 'karyawan',
                'image' => 'user.png'
            ],
            [
                'nip' => '020602-0004',
                'name' => 'Risky Memet Putra',
                'username' => 'Risky',
                'password' => Hash::make('password'),
                'tanggal_lahir' => '2002-06-02',
                'unit_kerja_id' => 3,
                'role' => 'karyawan',
                'image' => 'user.png'
            ],
            [
                'nip' => '040118-0005',
                'name' => 'Rahbil Saputra',
                'username' => '',
                'password' => Hash::make('password'),
                'tanggal_lahir' => '2003-01-18',
                'unit_kerja_id' => 3,
                'role' => 'karyawan',
                'image' => 'user.png'
            ],
            [
                'nip' => '860601-0006',
                'name' => 'Seprizon',
                'username' => 'Seprizon',
                'password' => Hash::make('password'),
                'tanggal_lahir' => '1986-06-01',
                'unit_kerja_id' => 3,
                'role' => 'karyawan',
                'image' => 'user.png'
            ],
            [
                'nip' => '020915-0007',
                'name' => 'Septio Yaldri Putra',
                'username' => 'Putra',
                'password' => Hash::make('password'),
                'tanggal_lahir' => '2002-09-15',
                'unit_kerja_id' => 3,
                'role' => 'karyawan',
                'image' => 'user.png'
            ]
        ];

        $tanggal = collect(range(0, 14))
            ->map(fn($day) => Carbon::create(2025, 1, 1)->addDays($day)->format('Y-m-d'))
            ->toArray();

        foreach ($user as $user) {
            User::create($user);
        }

        UnitKerja::create([
            'name' => 'Kasir',
            'code' => 'KR',
        ]);
        UnitKerja::create([
            'name' => 'Customer',
            'code' => 'CS'
        ]);
        UnitKerja::create([
            'name' => 'Mekanik',
            'code' => 'MK'
        ]);



        foreach ($tanggal as $date) {
            $absen = Absen::create([
                'tanggal' => $date,
                'checkin_start' => '07:30:00',
                'checkin_over' => '09:00:00',
                'checkout_start' => '16:00:00',
                'checkout_over' => '18:00:00',
                'status' => 1,
                'qr_code' => Str::uuid(),
            ]);

            $users = User::all();

            foreach ($users as $user) {
                $checkinTime = $this->randomTime($absen->tanggal, $absen->checkin_start, $absen->checkin_over);

                $checkoutTime = $this->randomTime($absen->tanggal, $absen->checkout_start, $absen->checkout_over);

                AbsenMasuk::create([
                    'user_id' => $user->id,
                    'absen_id' => $absen->id,
                    'checkin' => $checkinTime,
                    'keterangan' => 'Hadir',
                    'status' => true,
                ]);

                AbsenPulang::create([
                    'user_id' => $user->id,
                    'absen_id' => $absen->id,
                    'checkout' => $checkoutTime,
                    'keterangan' => 'Hadir',
                    'status' => true,
                ]);
            }
        }
    }

    private function randomTime(string $date, string $startTime, string $endTime): string
    {
        $startTimestamp = strtotime("$date $startTime");
        $endTimestamp = strtotime("$date $endTime");

        $randomTimestamp = rand($startTimestamp, $endTimestamp);

        return date('Y-m-d H:i:s', $randomTimestamp);
    }
}
