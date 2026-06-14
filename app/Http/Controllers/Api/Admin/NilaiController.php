<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\NilaiHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\NilaiResource;
use App\Models\Nilai;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    /**
     * Daftar semua nilai.
     */
    public function index(): JsonResponse
    {
        $nilais = Nilai::with(['siswa', 'guru'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return response()->json([
            'data' => NilaiResource::collection($nilais),
            'meta' => [
                'current_page' => $nilais->currentPage(),
                'last_page' => $nilais->lastPage(),
                'per_page' => $nilais->perPage(),
                'total' => $nilais->total(),
            ],
        ]);
    }

    /**
     * Simpan nilai baru.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'siswa_id' => ['required', 'exists:siswas,id'],
            'guru_id' => ['required', 'exists:gurus,id'],
            'nilai_tugas' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_uts' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_uas' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        $nilaiAkhir = NilaiHelper::hitungNilaiAkhir(
            (float) $validated['nilai_tugas'],
            (float) $validated['nilai_uts'],
            (float) $validated['nilai_uas']
        );

        $nilai = Nilai::create([
            'siswa_id' => $validated['siswa_id'],
            'guru_id' => $validated['guru_id'],
            'mata_pelajaran' => \App\Models\Guru::find($validated['guru_id'])->mata_pelajaran,
            'nilai_tugas' => $validated['nilai_tugas'],
            'nilai_uts' => $validated['nilai_uts'],
            'nilai_uas' => $validated['nilai_uas'],
            'nilai_akhir' => $nilaiAkhir,
            'status' => NilaiHelper::tentukanStatusKelulusan($nilaiAkhir),
        ]);

        return response()->json([
            'message' => 'Nilai berhasil ditambahkan.',
            'data' => new NilaiResource($nilai->load(['siswa', 'guru'])),
        ], 201);
    }

    /**
     * Detail nilai.
     */
    public function show(Nilai $nilai): JsonResponse
    {
        return response()->json([
            'data' => new NilaiResource($nilai->load(['siswa', 'guru'])),
        ]);
    }

    /**
     * Update data nilai.
     */
    public function update(Request $request, Nilai $nilai): JsonResponse
    {
        $validated = $request->validate([
            'siswa_id' => ['required', 'exists:siswas,id'],
            'guru_id' => ['required', 'exists:gurus,id'],
            'nilai_tugas' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_uts' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_uas' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        $nilai->update([
            'siswa_id' => $validated['siswa_id'],
            'guru_id' => $validated['guru_id'],
            'mata_pelajaran' => \App\Models\Guru::find($validated['guru_id'])->mata_pelajaran,
            'nilai_tugas' => $validated['nilai_tugas'],
            'nilai_uts' => $validated['nilai_uts'],
            'nilai_uas' => $validated['nilai_uas'],
        ]);

        return response()->json([
            'message' => 'Nilai berhasil diperbarui.',
            'data' => new NilaiResource($nilai->fresh()->load(['siswa', 'guru'])),
        ]);
    }

    /**
     * Hapus nilai.
     */
    public function destroy(Nilai $nilai): JsonResponse
    {
        $nilai->delete();

        return response()->json([
            'message' => 'Nilai berhasil dihapus.',
        ]);
    }
}
