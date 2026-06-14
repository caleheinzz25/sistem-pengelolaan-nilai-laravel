<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LaporanResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    /**
     * Dashboard siswa — nilai pribadi dan status kelulusan.
     */
    public function dashboard(): JsonResponse
    {
        $siswa = Auth::user()->siswa;

        if (! $siswa) {
            return response()->json(['message' => 'Data siswa tidak ditemukan.'], 403);
        }

        return response()->json([
            'data' => new LaporanResource($siswa),
        ]);
    }
}
