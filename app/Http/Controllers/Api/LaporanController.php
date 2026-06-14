<?php

namespace App\Http\Controllers\Api;

use App\Helpers\NilaiHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\LaporanResource;
use App\Http\Resources\SiswaResource;
use App\Models\Siswa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Daftar laporan nilai dengan filter.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Siswa::with('user');

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->input('kelas'));
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            $query->whereHas('nilais', function ($q) use ($status) {
                $q->where('status', $status);
            });
        }

        $siswas = $query->orderBy('nama')->paginate(20);

        return response()->json([
            'data' => SiswaResource::collection($siswas),
            'meta' => [
                'current_page' => $siswas->currentPage(),
                'last_page' => $siswas->lastPage(),
                'per_page' => $siswas->perPage(),
                'total' => $siswas->total(),
            ],
        ]);
    }

    /**
     * Detail laporan per siswa.
     */
    public function show(Siswa $siswa): JsonResponse
    {
        return response()->json([
            'data' => new LaporanResource($siswa),
        ]);
    }
}
