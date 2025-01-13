<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        return view('dashboard', [
            'title' => "Dashboard",
            'main_page' => '',
            'page' => 'Dashboard',
            'absen' => Absen::all(),
        ]);
    }
}
