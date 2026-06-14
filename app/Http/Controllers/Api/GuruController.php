<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NilaiResource;
use App\Models\Guru;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    /**
     * Dashboard guru.
     */
    public function dashboard(): JsonResponse
    {
        $guru = Auth::user()->guru;

        if (! $guru) {
            return response()->json(['message' => 'Data guru tidak ditemukan.'], 403);
        }

        $jumlahSiswaDiajar = Nilai::where('guru_id', $guru->id)
            ->distinct('siswa_id')
            ->count();

        $totalNilai = $guru->nilais()->count();
        $semuaNilai = $guru->nilais()->get(['nilai_akhir', 'status'])->toArray();
        $statistik = \App\Helpers\NilaiHelper::generateLaporan($semuaNilai);

        return response()->json([
            'guru' => $guru->only(['id', 'kode_guru', 'nama', 'mata_pelajaran']),
            'jumlah_siswa_diajar' => $jumlahSiswaDiajar,
            'total_nilai' => $totalNilai,
            'statistik' => $statistik,
        ]);
    }

    /**
     * Rekap nilai berdasarkan mata pelajaran guru.
     */
    public function rekap(): JsonResponse
    {
        $guru = Auth::user()->guru;

        if (! $guru) {
            return response()->json(['message' => 'Data guru tidak ditemukan.'], 403);
        }

        return response()->json([
            'guru' => $guru->only(['id', 'kode_guru', 'nama', 'mata_pelajaran']),
            'rekap' => $guru->getRekapNilai(),
        ]);
    }

    /**
     * Input nilai untuk siswa.
     */
    public function storeNilai(Request $request): JsonResponse
    {
        $guru = Auth::user()->guru;

        if (! $guru) {
            return response()->json(['message' => 'Data guru tidak ditemukan.'], 403);
        }

        $validated = $request->validate([
            'siswa_id' => ['required', 'exists:siswas,id'],
            'nilai_tugas' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_uts' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_uas' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        $siswa = Siswa::findOrFail($validated['siswa_id']);

        $nilai = $guru->inputNilai(
            $siswa,
            (float) $validated['nilai_tugas'],
            (float) $validated['nilai_uts'],
            (float) $validated['nilai_uas']
        );

        return response()->json([
            'message' => "Nilai {$guru->mata_pelajaran} untuk {$siswa->nama} berhasil disimpan.",
            'data' => new NilaiResource($nilai->load(['siswa', 'guru'])),
        ], 201);
    }
}
