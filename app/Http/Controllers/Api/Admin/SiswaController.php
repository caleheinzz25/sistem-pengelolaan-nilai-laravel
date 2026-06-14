<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SiswaResource;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Daftar semua siswa.
     */
    public function index(): JsonResponse
    {
        $siswas = Siswa::with('user')->orderBy('nama')->paginate(20);

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
     * Simpan siswa baru beserta akun login.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'unique:siswas,nis'],
            'nama' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $user = User::factory()->siswa()->create([
            'name' => $validated['nama'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $siswa = Siswa::create([
            'user_id' => $user->id,
            'nis' => $validated['nis'],
            'nama' => $validated['nama'],
            'kelas' => $validated['kelas'],
        ]);

        return response()->json([
            'message' => 'Siswa berhasil ditambahkan.',
            'data' => new SiswaResource($siswa->load('user')),
        ], 201);
    }

    /**
     * Detail siswa.
     */
    public function show(Siswa $siswa): JsonResponse
    {
        return response()->json([
            'data' => new SiswaResource($siswa->load('user')),
        ]);
    }

    /**
     * Update data siswa.
     */
    public function update(Request $request, Siswa $siswa): JsonResponse
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'unique:siswas,nis,'.$siswa->id],
            'nama' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'string', 'max:50'],
        ]);

        $siswa->update($validated);

        return response()->json([
            'message' => 'Siswa berhasil diperbarui.',
            'data' => new SiswaResource($siswa->fresh()->load('user')),
        ]);
    }

    /**
     * Hapus siswa beserta akun login dan nilai.
     */
    public function destroy(Siswa $siswa): JsonResponse
    {
        $siswa->nilais()->delete();
        $siswa->user?->delete();
        $siswa->delete();

        return response()->json([
            'message' => 'Siswa berhasil dihapus.',
        ]);
    }
}
