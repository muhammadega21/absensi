<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\AbsenMasuk;
use App\Models\AbsenPulang;
use App\Models\User;
use Carbon\Carbon;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AbsenController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;

        $absens = Absen::with([
            'absenMasuk' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            },
            'absenPulang' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }
        ])->whereHas('absenMasuk', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->orWhereHas('absenPulang', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->latest()->get();


        return view('absen.index', [
            'title' => "Absen",
            'main_page' => '',
            'page' => 'Absen',
            'datas' => Absen::latest()->get(),
            'absens' => $absens,
        ]);
    }

    public function show($id)
    {
        $absens = Absen::where('id', $id)->get();
        if ($absens->isEmpty()) {
            return abort(404);
        }


        return view('absen.list', [
            'title' => "Absen List",
            'main_page' => 'Absen',
            'page' => 'Absen list',
            'datas' =>  $absens,
            'users' => User::all()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|unique:absens,tanggal',
            'checkin_start' => 'required',
            'checkin_over' => 'required',
            'checkout_start' => 'required',
            'checkout_over' => 'required',
        ], [
            'tanggal.required' => 'Tanggal Harus Diisi!',
            'tanggal.unique' => 'Absen Pada Tanggal Ini Sudah Ada!',

            'checkin_start.required' => 'Absen Masuk(Mulai) Harus Diisi!',
            'checkin_out.required' => 'Absen Masuk(Berakhir) Harus Diisi!',

            'checkout_start.required' => 'Absen Pulang(Mulai) Harus Diisi!',
            'checkout_over.required' => 'Absen Pulang(Berakhir) Harus Diisi!',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('addAbsen', 'Gagal Menambah Absen');
        }

        Absen::create([
            'tanggal' => $request->input('tanggal'),
            'checkin_start' => $request->input('checkin_start'),
            'checkin_over' => $request->input('checkin_over'),
            'checkout_start' => $request->input('checkout_start'),
            'checkout_over' => $request->input('checkout_over'),
            'status' => false,
            'qr_code' => Str::uuid()
        ]);

        return redirect('/absen')->with('success', 'Berhasil menambah Absen');
    }

    public function storeListAbsen(Request $request, $id)
    {
        $absenMasuk = AbsenMasuk::where('user_id', $request->user_id)->first();
        $absenPulang = AbsenPulang::where('user_id', $request->user_id)->first();
        if ($absenMasuk && $absenPulang) {
            return back()->with('error', 'Karyawan Sudah Mengambil Absen Masuk dan Pulang');
        } elseif ($absenMasuk) {
            return back()->with('error', 'Karyawan Sudah Mengambil Absen Masuk ');
        } elseif ($absenPulang) {
            return back()->with('error', 'Karyawan Sudah Mengambil Absen Pulang ');
        }

        $validator = Validator::make($request->all(), [
            'checkin' => 'required',
            'checkout' => 'required',
        ], [
            'checkin.required' => 'Jam Masuk Tidak Boleh Kosong!',
            'checkout.required' => 'Jam Pulang Tidak Boleh Kosong!',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('addListAbsen', 'Gagal Menambah Absen Karyawan');
        }

        AbsenMasuk::create([
            'user_id' => $request->input('user_id'),
            'absen_id' => $id,
            'checkin' => $request->input('checkin'),
            'keterangan' => $request->input('keterangan'),
            'status' => 1
        ]);
        AbsenPulang::create([
            'user_id' => $request->input('user_id'),
            'absen_id' => $id,
            'checkout' => $request->input('checkout'),
            'keterangan' => $request->input('keterangan'),
            'status' => 1
        ]);

        return back()->with('success', 'Berhasil menambah absen karyawan');
    }

    public function attendace($id)
    {
        $absen = Absen::findorfail($id);

        $timeNow = Carbon::now('Asia/Jakarta')->translatedFormat('H:i:s');
        $dateNow = Carbon::now('Asia/Jakarta')->toDateString();
        $textStatus = 0;


        $startTime = ($timeNow > $absen->checkin_over) ? $absen->checkout_start : $absen->checkin_start;
        $endTime = ($timeNow > $absen->checkin_over) ? $absen->checkout_over : $absen->checkin_over;

        if ($absen->tanggal > $dateNow) {
            $attendanceStatus = 'Absen Belum Dimulai';
        } elseif ($absen->status !== 0 || $absen->tanggal !== $dateNow) {
            $attendanceStatus = 'Absen Tutup';
        } elseif ($timeNow >= $absen->checkin_start && $timeNow <= $absen->checkin_over) {
            $attendanceStatus = 'Absen Masuk (' . $absen->checkin_start . ' - ' . $absen->checkin_over . ')';
        } elseif ($timeNow > $absen->checkin_over && $timeNow < $absen->checkout_start) {
            $attendanceStatus = 'Absen Masuk Berakhir (' . $absen->checkin_start . ' - ' . $absen->checkin_over . ')';
            $textStatus = 1;
        } elseif ($timeNow >= $absen->checkout_start && $timeNow <= $absen->checkout_over) {
            $attendanceStatus = 'Absen Pulang (' . $absen->checkout_start . ' - ' . $absen->checkout_over . ')';
        } elseif ($timeNow > $absen->checkout_over) {
            $attendanceStatus = 'Absen Pulang Berakhir (' . $absen->checkout_start . ' - ' . $absen->checkout_over . ')';
            $textStatus = 1;
        } else {
            $attendanceStatus = 'Di Luar Jam Absen';
        }


        return view('absen.attendance', [
            'title' => 'Attendance',
            'absen' => $absen,
            'startTime' => $startTime,
            'endTime' => $endTime,
            'attendanceStatus' => $attendanceStatus,
            'textStatus' => $textStatus,
        ]);
    }

    public function checkin(Request $request)
    {
        $absen = Absen::where('qr_code', $request->qrcode)->first();
        $timeNow = Carbon::now('Asia/Jakarta')->format('H:i:s');
        $dateNow = Carbon::now('Asia/Jakarta')->toDateString();
        $userId = Auth::user()->id;

        if (!$absen) {
            return redirect('/absen')->with('error', 'QR Code tidak valid');
        }

        if (Carbon::parse($absen->tanggal)->toDateString() > $dateNow) {
            return redirect('/absen')->with('error', 'Absen belum dimulai');
        }

        if (Carbon::parse($absen->tanggal)->toDateString() !== $dateNow) {
            return redirect('/absen')->with('error', 'Di luar jam absen');
        }

        if ($absen->status !== 0) {
            return redirect('/absen')->with('error', 'Absen sudah berakhir');
        }

        if ($timeNow >= $absen->checkin_start && $timeNow <= $absen->checkin_over) {
            $existingCheckin = AbsenMasuk::where('user_id', $userId)->where('absen_id', $absen->id)->first();
            if ($existingCheckin) {
                return redirect('/absen')->with('error', 'Anda sudah mengambil absen masuk');
            }

            AbsenMasuk::create([
                'user_id' => $userId,
                'absen_id' => $absen->id,
                'checkin' => $timeNow,
                'status' => true
            ]);
            return redirect('/absen')->with('success', 'Berhasil absen masuk');
        } elseif ($timeNow > $absen->checkin_over && $timeNow < $absen->checkout_start) {
            $existingCheckin = AbsenMasuk::where('user_id', $userId)->where('absen_id', $absen->id)->first();
            if ($existingCheckin) {
                return redirect('/absen')->with('error', 'Anda sudah mengambil absen masuk');
            }

            AbsenMasuk::create([
                'user_id' => $userId,
                'absen_id' => $absen->id,
                'checkin' => $timeNow,
                'status' => true,
                'keterangan' => 'Terlambat'
            ]);
            return redirect('/absen')->with('warning', 'Terlambat mengambil absen masuk');
        } elseif ($timeNow >= $absen->checkout_start && $timeNow <= $absen->checkout_over) {
            $existingCheckout = AbsenPulang::where('user_id', $userId)->where('absen_id', $absen->id)->first();
            if ($existingCheckout) {
                return redirect('/absen')->with('error', 'Anda sudah mengambil absen pulang');
            }

            AbsenPulang::create([
                'user_id' => $userId,
                'absen_id' => $absen->id,
                'checkout' => $timeNow,
                'status' => true
            ]);
            return redirect('/absen')->with('success', 'Berhasil absen pulang');
        }
        return redirect('/absen')->with('error', 'Di luar jam absen');
    }

    public function closeAbsen($id)
    {
        $absen = Absen::where('id', $id)->first();
        $tanggal = $absen->tanggal;
        $usersWithoutAbsenMasuk = DB::table('users')
            ->leftJoin('absen_masuks', function ($join) use ($tanggal) {
                $join->on('users.id', '=', 'absen_masuks.user_id')
                    ->whereDate('absen_masuks.created_at', '=', $tanggal);
            })
            ->whereNull('absen_masuks.id') // Tidak ada absen masuk
            ->select('users.id', 'users.name', 'users.nip')
            ->distinct()
            ->get();

        // Pengguna yang tidak memiliki absen pulang
        $usersWithoutAbsenPulang = DB::table('users')
            ->leftJoin('absen_pulangs', function ($join) use ($tanggal) {
                $join->on('users.id', '=', 'absen_pulangs.user_id')
                    ->whereDate('absen_pulangs.created_at', '=', $tanggal);
            })
            ->whereNull('absen_pulangs.id') // Tidak ada absen pulang
            ->select('users.id', 'users.name', 'users.nip')
            ->distinct()
            ->get();

        // Pengguna yang tidak memiliki keduanya
        $usersWithoutBoth = DB::table('users')
            ->leftJoin('absen_masuks', function ($join) use ($tanggal) {
                $join->on('users.id', '=', 'absen_masuks.user_id')
                    ->whereDate('absen_masuks.created_at', '=', $tanggal);
            })
            ->leftJoin('absen_pulangs', function ($join) use ($tanggal) {
                $join->on('users.id', '=', 'absen_pulangs.user_id')
                    ->whereDate('absen_pulangs.created_at', '=', $tanggal);
            })
            ->whereNull('absen_masuks.id') // Tidak ada absen masuk
            ->whereNull('absen_pulangs.id') // Tidak ada absen pulang
            ->select('users.id', 'users.name', 'users.nip')
            ->distinct()
            ->get();


        foreach ($usersWithoutBoth as $user) {
            $this->createAbsenMasuk($user->id, $id);
            $this->createAbsenPulang($user->id, $id);
        }

        $processedUserIds = $usersWithoutBoth->pluck('id')->toArray();

        foreach ($usersWithoutAbsenMasuk as $user) {
            if (!in_array($user->id, $processedUserIds)) {
                $this->createAbsenMasuk($user->id, $id);
            }
        }

        foreach ($usersWithoutAbsenPulang as $user) {
            if (!in_array($user->id, $processedUserIds)) {
                $this->createAbsenPulang($user->id, $id);
            }
        }

        $absen->update([
            'status' => 1
        ]);

        return redirect('/absen')->with('success', 'Berhasil menutup absen');
    }

    private function createAbsenMasuk($userId, $absenID)
    {
        $existing = AbsenMasuk::where('user_id', $userId)
            ->where('absen_id', $absenID)
            ->exists();

        if (!$existing) {
            AbsenMasuk::create([
                'user_id' => $userId,
                'absen_id' => $absenID,
                'checkin' => null,
                'keterangan' => 'Tidak Hadir',
                'status' => 0,
            ]);
        }
    }
    private function createAbsenPulang($userId, $absenID)
    {
        $existing = AbsenPulang::where('user_id', $userId)
            ->where('absen_id', $absenID)
            ->exists();

        if (!$existing) {
            AbsenPulang::create([
                'user_id' => $userId,
                'absen_id' => $absenID,
                'checkout' => null,
                'keterangan' => 'Tidak Hadir',
                'status' => 0,
            ]);
        }
    }

    public function destroyListAbsen(int $id)
    {
        $absenMasuk = AbsenMasuk::where('user_id', $id)->first();
        $absenPulang = AbsenPulang::where('user_id', $id)->first();
        if ($absenMasuk && $absenPulang) {
            $absenMasuk->delete();
            $absenPulang->delete();
        } elseif ($absenMasuk) {
            $absenMasuk->delete();
        } elseif ($absenPulang) {
            $absenPulang->delete();
        } else {
            return back()->with('error', 'Gagal menghapus absen karyawan');
        }

        return back()->with('success', 'Berhasil menghapus absen karyawan');
    }

    public function destroy(int $id)
    {
        $data = Absen::where('id', $id)->first();
        AbsenMasuk::where('absen_id', $id)->delete();
        AbsenPulang::where('absen_id', $id)->delete();
        $data->delete();
        return redirect('absen')->with('success', 'Berhasil menghapus absen');
    }
}
