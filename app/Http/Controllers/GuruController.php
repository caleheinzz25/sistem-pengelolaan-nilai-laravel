<?php

namespace App\Http\Controllers;

use App\Helpers\NilaiHelper;
use App\Models\Guru;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class GuruController extends Controller
{
    /**
     * Dashboard Guru.
     */
    public function dashboard(): View
    {
        $guru = Auth::user()->guru;

        if (! $guru) {
            abort(403, 'Data guru tidak ditemukan.');
        }

        $jumlahSiswaDiajar = Nilai::where('guru_id', $guru->id)
            ->distinct('siswa_id')
            ->count();
        $totalNilai = $guru->nilais()->count();

        // Statistik menggunakan NilaiHelper (pemrograman terstruktur)
        $semuaNilai = $guru->nilais()->get(['nilai_akhir', 'status'])->toArray();
        $statistik = NilaiHelper::generateLaporan($semuaNilai);

        return view('guru.dashboard', compact('guru', 'jumlahSiswaDiajar', 'totalNilai', 'statistik'));
    }

    /**
     * Rekap nilai berdasarkan mata pelajaran guru.
     */
    public function rekapNilai(): View
    {
        $guru = Auth::user()->guru;

        if (! $guru) {
            abort(403, 'Data guru tidak ditemukan.');
        }

        $rekap = $guru->getRekapNilai();

        return view('guru.rekap', compact('guru', 'rekap'));
    }

    /**
     * Form input nilai untuk seorang siswa.
     */
    public function formInputNilai(): View
    {
        $guru = Auth::user()->guru;

        if (! $guru) {
            abort(403, 'Data guru tidak ditemukan.');
        }

        $siswas = Siswa::orderBy('kelas')->orderBy('nama')->get();

        // Cek siswa yang sudah memiliki nilai
        $siswaSudahDinilai = Nilai::where('guru_id', $guru->id)
            ->pluck('siswa_id')
            ->toArray();

        return view('guru.input-nilai', compact('guru', 'siswas', 'siswaSudahDinilai'));
    }

    /**
     * Simpan nilai siswa (menggunakan method inputNilai() di model Guru — OOP).
     */
    public function storeNilai(Request $request): RedirectResponse
    {
        $guru = Auth::user()->guru;

        if (! $guru) {
            abort(403, 'Data guru tidak ditemukan.');
        }

        $validated = $request->validate([
            'siswa_id' => ['required', 'exists:siswas,id'],
            'nilai_tugas' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_uts' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_uas' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        $siswa = Siswa::findOrFail($validated['siswa_id']);

        // Menggunakan method OOP dari model Guru
        $guru->inputNilai(
            $siswa,
            (float) $validated['nilai_tugas'],
            (float) $validated['nilai_uts'],
            (float) $validated['nilai_uas']
        );

        return redirect()
            ->route('guru.rekap')
            ->with('success', "Nilai {$guru->mata_pelajaran} untuk {$siswa->nama} berhasil disimpan.");
    }
}
