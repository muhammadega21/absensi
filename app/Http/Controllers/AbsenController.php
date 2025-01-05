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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AbsenController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;

        // Absen Masuk dan Pulang dengan filter user_id
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
            })
            ->get();


        return view('absen.index', [
            'title' => "Absen",
            'main_page' => '',
            'page' => 'Absen',
            'datas' => Absen::all(),
            'absens' => $absens
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
        } elseif ($absen->status !== 0) {
            $attendanceStatus = 'Absen Tutup';
        } elseif ($timeNow >= $absen->checkin_start && $timeNow <= $absen->checkin_over) {
            $attendanceStatus = 'Absen Masuk (' . $absen->checkoin_start . ' - ' . $absen->checkoin_over . ')';
        } elseif ($timeNow > $absen->checkin_over && $timeNow < $absen->checkout_start) {
            $attendanceStatus = 'Absen Masuk Berakhir (' . $absen->checkoin_start . ' - ' . $absen->checkoin_over . ')';
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
            'textStatus' => $textStatus
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
        } elseif ($timeNow > $absen->checkout_over && $absen->status === 0) {
            $existingCheckout = AbsenPulang::where('user_id', $userId)->where('absen_id', $absen->id)->first();
            if ($existingCheckout) {
                return redirect('/absen')->with('error', 'Anda sudah mengambil absen pulang');
            }

            AbsenPulang::create([
                'user_id' => $userId,
                'absen_id' => $absen->id,
                'checkout' => $timeNow,
                'status' => true,
                'keterangan' => 'Terlambat'
            ]);
            return redirect('/absen')->with('warning', 'Terlambat mengambil absen pulang');
        }

        return redirect('/absen')->with('error', 'Di luar jam absen');
    }

    public function closeAbsen($id)
    {
        $absen = Absen::findorfail($id);

        $absenMasuk = AbsenMasuk::where('absen_id', $id)->first();
        // Cek apakah user memiliki absen pulang
        $absenPulang = AbsenPulang::where('absen_id', $id)->get();

        return $absenPulang;



        // $absen->update([
        //     'status' => 1
        // ]);
        // return redirect('/absen')->with('success', 'Berhasil Menutup Absen');
    }
}
