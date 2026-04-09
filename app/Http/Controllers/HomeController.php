<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Kategori;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $totalSelesai   = Pengaduan::where('status', '2')->count();
        $totalSiswa     = User::where('level', 'siswa')->count();
        $totalPengaduan = Pengaduan::count();
        $totalKategori  = Kategori::count();

        return view('welcome', compact(
            'totalSelesai',
            'totalSiswa',
            'totalPengaduan',
            'totalKategori'
        ));
    }
}