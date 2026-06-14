<?php

namespace App\Http\Controllers;

use App\Helpers\NilaiHelper;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanController extends Controller
{
    /**
     * Halaman laporan — menampilkan nilai seluruh siswa dengan filter.
     */
    public function index(Request $request): View
    {
        $kelas = $request->get('kelas');
        $status = $request->get('status');

        $siswas = Siswa::with('nilais')
            ->when($kelas, fn ($query) => $query->where('kelas', $kelas))
            ->orderBy('kelas')
            ->orderBy('nama')
            ->get();

        // Filter manual by status karena status dihitung dari rata-rata
        if ($status) {
            $siswas = $siswas->filter(fn (Siswa $s) => $s->getStatusKelulusan() === $status);
        }

        $laporanData = $siswas->map(fn (Siswa $s) => [
            'nis' => $s->nis,
            'nama' => $s->nama,
            'kelas' => $s->kelas,
            'rata_rata' => $s->getRataRataNilaiAkhir(),
            'status' => $s->getStatusKelulusan(),
        ])->values()->toArray();

        // Gunakan NilaiHelper (pemrograman terstruktur) untuk statistik global
        $statistikGlobal = NilaiHelper::generateLaporan(
            $siswas->flatMap(fn (Siswa $s) => $s->nilais->toArray())->toArray()
        );

        // Daftar kelas untuk filter
        $daftarKelas = Siswa::distinct()->orderBy('kelas')->pluck('kelas');

        return view('laporan.index', compact('laporanData', 'statistikGlobal', 'daftarKelas', 'kelas', 'status'));
    }

    /**
     * Detail laporan per siswa.
     */
    public function show(Siswa $siswa): View
    {
        $laporan = $siswa->getLaporan();

        return view('laporan.show', compact('siswa', 'laporan'));
    }

    /**
     * Cetak laporan (tampilan print-friendly).
     */
    public function print(): View
    {
        $siswas = Siswa::with('nilais')->orderBy('kelas')->orderBy('nama')->get();

        $laporanData = $siswas->map(fn (Siswa $s) => $s->getLaporan())->toArray();

        return view('laporan.print', compact('laporanData'));
    }
}
