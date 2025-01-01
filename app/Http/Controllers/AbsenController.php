<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use Illuminate\Http\Request;

class AbsenController extends Controller
{
    public function index()
    {
        return view('absen', [
            'title' => "Absen",
            'main_page' => '',
            'page' => 'Absen',
            'datas' => Absen::all(),
        ]);
    }
}
