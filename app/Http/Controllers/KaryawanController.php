<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use App\Models\User;
use Endroid\QrCode\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class KaryawanController extends Controller
{
    public function index()
    {
        return view('master-data.karyawan', [
            'title' => "Karyawan",
            'main_page' => '',
            'page' => 'Karyawan',
            'datas' => User::all(),
            'unit_kerja' => UnitKerja::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'username' => 'required|max:10',
            'password' => 'required|min:4',
            'tanggal_lahir' => 'required',
            'image' => 'mimes:jpeg,jpg,png|max:3000'
        ], [
            'name.required' => 'Nama Tidak Boleh Kosong!',
            'name.max' => 'Nama Maksimal 50 Karakter!',

            'username.required' => 'Nama Panggilan Tidak Boleh Kosong!',
            'username.max' => 'Nama Panggilan Maksimal 10 Karakter!',

            'password.required' => 'Password Tidak Boleh Kosong!',
            'password.min' => 'Password Minimal 4 Karakter!',

            'tanggal_lahir' => 'Tanggal Lahir Tidak Boleh Kosong!'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('addKaryawan', 'Gagal Menambah Karyawan');
        }

        // NIP
        $lastNIP = User::latest('nip')->first();
        if ($lastNIP) {
            $parts = explode('-', $lastNIP);
            $lastNumber = (int)$parts[1];
            $lastNumber += 1;
            $nextNIP = str_pad($lastNumber, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNIP = 0001;
        }
        $date = date('ymd', strtotime($request->input('tanggal_lahir')));
        $nip = $date . '-' . $nextNIP;

        // image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $image = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/user'), $image);
        } else {
            $image = 'user.png';
        }

        User::create([
            'nip' => $nip,
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
            'unit_kerja_id' => $request->input('unit_kerja_id'),
            'role' => $request->input('role'),
            'image' => $image,
            'qr_code' => Str::uuid()
        ]);

        return redirect('/karyawan')->with('success', 'Berhasil Menambah Karyawan');
    }

    public function update(Request $request, int $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name' => 'required|max:50',
            'username' => 'required|max:10',
            'tanggal_lahir' => 'required',
            'image' => 'mimes:jpeg,jpg,png|max:3000'
        ];

        if ($request->input('password')) {
            $rules['password'] = 'required|min:4';
        }

        $validator = Validator::make($request->all(), $rules, [
            'name.required' => 'Nama Tidak Boleh Kosong!',
            'name.max' => 'Nama Maksimal 50 Karakter!',

            'username.required' => 'Nama Panggilan Tidak Boleh Kosong!',
            'username.max' => 'Nama Panggilan Maksimal 10 Karakter!',

            'password.required' => 'Password Tidak Boleh Kosong!',
            'password.min' => 'Password Minimal 4 Karakter!',

            'tanggal_lahir' => 'Tanggal Lahir Tidak Boleh Kosong!'
        ]);



        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('updateKaryawan', 'Gagal Update Karyawan');
        }

        $image = $user->image;

        if ($request->hasFile('image')) {
            if ($user->image && $user->image !== 'user.png') {
                $oldImagePath = public_path('img/user/' . $user->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $file = $request->file('image');
            $image = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/user'), $image);
            $user->image = $image;
        }

        $input = [
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
            'unit_kerja_id' => $request->input('unit_kerja_id'),
            'role' => $request->input('role'),
            'image' => $image,
        ];

        if ($request->input('password')) {
            $input['password'] = $request->input('password');
        }

        $user->update($input);

        return redirect('/karyawan')->with('success', 'Berhasil Update Karyawan');
    }

    public function destroy(int $id)
    {
        $data = User::where('id', $id)->first();
        if ($data->image !== 'user.png') {
            $imagePath = public_path('img/user/' . $data->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        $data->delete();
        return redirect('/karyawan')->with('success', 'Berhasil menghapus data');
    }
}
