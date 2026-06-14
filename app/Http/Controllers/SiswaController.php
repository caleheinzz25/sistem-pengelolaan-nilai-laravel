<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SiswaController extends Controller
{
    /**
     * Dashboard Siswa — menampilkan nilai pribadi dan status kelulusan.
     */
    public function dashboard(): View
    {
        $siswa = Auth::user()->siswa;

        if (! $siswa) {
            abort(403, 'Data siswa tidak ditemukan.');
        }

        // Gunakan method OOP dari model Siswa
        $laporan = $siswa->getLaporan();

        return view('siswa.dashboard', compact('siswa', 'laporan'));
    }
}
