<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile', [
            'title' => "Profile",
            'main_page' => '',
            'page' => 'Profile',
            'data' => User::where('id', Auth::user()->id)->first(),
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'username' => 'required|max:10',
            'tanggal_lahir' => 'required',
            'image' => 'mimes:jpeg,jpg,png|max:3000'
        ], [
            'name.required' => 'Nama Tidak Boleh Kosong!',
            'name.max' => 'Nama Maksimal 50 Karakter!',

            'username.required' => 'Nama Panggilan Tidak Boleh Kosong!',
            'username.max' => 'Nama Panggilan Maksimal 10 Karakter!',

            'tanggal_lahir' => 'Tanggal Lahir Tidak Boleh Kosong!'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('addKaryawan', 'Gagal Menambah Karyawan');
        }

        $user = User::find(Auth::user()->id);

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
            'image' => $image,
        ];

        $user->update($input);

        return redirect('/profile')->with('success', 'Berhasil Update Profile');
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'newpassword' => 'required|min:4|same:password_confirm',
            'password_confirm' => 'required|same:newpassword',
        ], [
            'password.required' => 'Password tidak boleh kosong.',
            'newpassword.required' => 'Password tidak boleh kosong.',
            'newpassword.min' => 'Password minimal 4 karakter.',
            'newpassword.same' => 'Konfirmasi password tidak sama.',

            'password_confirm.required' => 'password tidak boleh kosong.',
            'password_confirm.same' => 'Konfirmasi password tidak sama.',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Password tidak sesuai');
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Gagal ganti password');
        }

        User::where('id', $user->id)->update([
            'password' => Hash::make($request->newpassword),
        ]);

        return redirect('/profile')->with('success', 'Password berhasil dirubah');
    }
}
