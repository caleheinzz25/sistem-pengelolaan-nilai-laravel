<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\GuruResource;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    /**
     * Daftar semua guru.
     */
    public function index(): JsonResponse
    {
        $gurus = Guru::with('user')->orderBy('nama')->paginate(20);

        return response()->json([
            'data' => GuruResource::collection($gurus),
            'meta' => [
                'current_page' => $gurus->currentPage(),
                'last_page' => $gurus->lastPage(),
                'per_page' => $gurus->perPage(),
                'total' => $gurus->total(),
            ],
        ]);
    }

    /**
     * Simpan guru baru beserta akun login.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'kode_guru' => ['required', 'string', 'unique:gurus,kode_guru'],
            'nama' => ['required', 'string', 'max:255'],
            'mata_pelajaran' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $user = User::factory()->guru()->create([
            'name' => $validated['nama'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $guru = Guru::create([
            'user_id' => $user->id,
            'kode_guru' => $validated['kode_guru'],
            'nama' => $validated['nama'],
            'mata_pelajaran' => $validated['mata_pelajaran'],
        ]);

        return response()->json([
            'message' => 'Guru berhasil ditambahkan.',
            'data' => new GuruResource($guru->load('user')),
        ], 201);
    }

    /**
     * Detail guru.
     */
    public function show(Guru $guru): JsonResponse
    {
        return response()->json([
            'data' => new GuruResource($guru->load('user')),
        ]);
    }

    /**
     * Update data guru.
     */
    public function update(Request $request, Guru $guru): JsonResponse
    {
        $validated = $request->validate([
            'kode_guru' => ['required', 'string', 'unique:gurus,kode_guru,'.$guru->id],
            'nama' => ['required', 'string', 'max:255'],
            'mata_pelajaran' => ['required', 'string', 'max:100'],
        ]);

        $guru->update($validated);

        return response()->json([
            'message' => 'Guru berhasil diperbarui.',
            'data' => new GuruResource($guru->fresh()->load('user')),
        ]);
    }

    /**
     * Hapus guru beserta akun login dan nilai.
     */
    public function destroy(Guru $guru): JsonResponse
    {
        $guru->nilais()->delete();
        $guru->user?->delete();
        $guru->delete();

        return response()->json([
            'message' => 'Guru berhasil dihapus.',
        ]);
    }
}
