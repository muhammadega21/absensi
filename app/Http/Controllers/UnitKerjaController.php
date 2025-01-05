<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitKerjaController extends Controller
{
    public function index()
    {
        return view('master-data.unit_kerja', [
            'title' => "Unit Kerja",
            'main_page' => '',
            'page' => 'Unit Kerja',
            'datas' => UnitKerja::all()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:30|unique:unit_kerjas,name',
            'code' => 'required|max:6|unique:unit_kerjas,code'
        ], [
            'name.required' => 'Nama Unit Kerja Harus Diisi!',
            'name.max' => 'Nama Unit Kerja Maksimal 30 Karakter!',
            'name.unique' => 'Nama Unit Kerja Sudah Ada!',

            'code.required' => 'Nama Unit Kerja Harus Diisi!',
            'code.max' => 'Nama Unit Kerja Maksimal 6 Karakter!',
            'code.unique' => 'Kode Unit Kerja Sudah Ada!'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('addUnitKerja', 'Gagal Menambah Unit Kerja');
        }

        UnitKerja::create([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
        ]);

        return redirect('/unit_kerja')->with('success', 'Berhasil menambah unit kerja');
    }

    public function update(Request $request, int $id)
    {
        $data = UnitKerja::where('id', $id)->first();
        $rules = [];
        if ($request->input('name') != $data->name) {
            $rules['name'] = 'required|max:30|unique:unit_kerjas,name';
        }
        if ($request->input('code') != $data->code) {
            $rules['code'] = 'required|max:6|unique:unit_kerjas,code';
        }

        $validator = Validator::make($request->all(), $rules, [
            'name.required' => 'Nama Unit Kerja Harus Diisi!',
            'name.max' => 'Nama Unit Kerja Maksimal 30 Karakter!',
            'name.unique' => 'Nama Unit Kerja Sudah Ada!',

            'code.required' => 'Nama Unit Kerja Harus Diisi!',
            'code.max' => 'Nama Unit Kerja Maksimal 6 Karakter!',
            'code.unique' => 'Kode Unit Kerja Sudah Ada!'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('updateUnitKerja', 'Gagal Update Unit Kerja');
        }

        $data->update([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
        ]);

        return redirect('/unit_kerja')->with('success', 'Berhasil update unit kerja');
    }

    public function destroy(int $id)
    {
        $data = UnitKerja::where('id', $id)->first();
        $data->delete();
        return redirect('/unit_kerja')->with('success', 'Berhasil menghapus data');
    }
}
