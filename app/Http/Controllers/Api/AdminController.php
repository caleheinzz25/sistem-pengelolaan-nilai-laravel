<?php

namespace App\Http\Controllers\Api;

use App\Helpers\NilaiHelper;
use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    /**
     * Dashboard admin dengan ringkasan statistik.
     */
    public function dashboard(): JsonResponse
    {
        $totalSiswa = Siswa::count();
        $totalGuru = Guru::count();
        $totalNilai = Nilai::count();

        $semuaNilai = Nilai::get(['nilai_akhir', 'status'])->toArray();
        $statistik = NilaiHelper::generateLaporan($semuaNilai);

        return response()->json([
            'total_siswa' => $totalSiswa,
            'total_guru' => $totalGuru,
            'total_nilai' => $totalNilai,
            'statistik' => $statistik,
        ]);
    }
}
