<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AbsenController extends Controller
{
    public function index()
    {
        return view('absen.index', [
            'title' => "Absen",
            'main_page' => '',
            'page' => 'Absen',
            'datas' => Absen::all(),
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
        $absen = Absen::find($id);

        return view('absen.attendance', [
            'title' => 'Attendance',
            'absen' => $absen,
        ]);
    }
}
