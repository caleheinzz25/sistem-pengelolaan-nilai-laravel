<?php

namespace App\Http\Controllers;

use App\Helpers\NilaiHelper;
use App\Models\Guru;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Dashboard Admin — ringkasan data.
     */
    public function dashboard(): View
    {
        $totalSiswa = Siswa::count();
        $totalGuru = Guru::count();
        $totalNilai = Nilai::count();

        // Gunakan NilaiHelper (pemrograman terstruktur) untuk statistik
        $semuaNilai = Nilai::all(['nilai_akhir', 'status'])->toArray();
        $statistik = NilaiHelper::generateLaporan($semuaNilai);

        return view('admin.dashboard', compact('totalSiswa', 'totalGuru', 'totalNilai', 'statistik'));
    }

    // ============================================================
    // CRUD SISWA
    // ============================================================

    /**
     * Daftar semua siswa.
     */
    public function indexSiswa(): View
    {
        $siswas = Siswa::with('user')->latest()->paginate(15);

        return view('admin.siswa.index', compact('siswas'));
    }

    /**
     * Form tambah siswa.
     */
    public function createSiswa(): View
    {
        return view('admin.siswa.create');
    }

    /**
     * Simpan data siswa baru.
     */
    public function storeSiswa(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'unique:siswas,nis'],
            'nama' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'string', 'max:50'],
        ]);

        // Buat akun user untuk siswa
        $user = User::create([
            'name' => $validated['nama'],
            'email' => str_replace(' ', '', strtolower($validated['nama'])).'@siswa.test',
            'password' => bcrypt('password'),
            'role' => 'siswa',
        ]);

        Siswa::create([
            'nis' => $validated['nis'],
            'nama' => $validated['nama'],
            'kelas' => $validated['kelas'],
            'user_id' => $user->id,
        ]);

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    /**
     * Form edit data siswa.
     */
    public function editSiswa(Siswa $siswa): View
    {
        return view('admin.siswa.edit', compact('siswa'));
    }

    /**
     * Update data siswa.
     */
    public function updateSiswa(Request $request, Siswa $siswa): RedirectResponse
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'unique:siswas,nis,'.$siswa->id],
            'nama' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'string', 'max:50'],
        ]);

        $siswa->update($validated);

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Hapus data siswa.
     */
    public function destroySiswa(Siswa $siswa): RedirectResponse
    {
        // Hapus akun user terkait
        $siswa->user?->delete();
        $siswa->delete();

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }

    // ============================================================
    // CRUD GURU
    // ============================================================

    /**
     * Daftar semua guru.
     */
    public function indexGuru(): View
    {
        $gurus = Guru::with('user')->latest()->paginate(15);

        return view('admin.guru.index', compact('gurus'));
    }

    /**
     * Form tambah guru.
     */
    public function createGuru(): View
    {
        return view('admin.guru.create');
    }

    /**
     * Simpan data guru baru.
     */
    public function storeGuru(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_guru' => ['required', 'string', 'unique:gurus,kode_guru'],
            'nama' => ['required', 'string', 'max:255'],
            'mata_pelajaran' => ['required', 'string', 'max:100'],
        ]);

        $user = User::create([
            'name' => $validated['nama'],
            'email' => str_replace([' ', ',', '.'], '', strtolower($validated['nama'])).'@sekolah.test',
            'password' => bcrypt('password'),
            'role' => 'guru',
        ]);

        Guru::create([
            'kode_guru' => $validated['kode_guru'],
            'nama' => $validated['nama'],
            'mata_pelajaran' => $validated['mata_pelajaran'],
            'user_id' => $user->id,
        ]);

        return redirect()
            ->route('admin.guru.index')
            ->with('success', 'Data guru berhasil ditambahkan.');
    }

    /**
     * Form edit guru.
     */
    public function editGuru(Guru $guru): View
    {
        return view('admin.guru.edit', compact('guru'));
    }

    /**
     * Update data guru.
     */
    public function updateGuru(Request $request, Guru $guru): RedirectResponse
    {
        $validated = $request->validate([
            'kode_guru' => ['required', 'string', 'unique:gurus,kode_guru,'.$guru->id],
            'nama' => ['required', 'string', 'max:255'],
            'mata_pelajaran' => ['required', 'string', 'max:100'],
        ]);

        $guru->update($validated);

        return redirect()
            ->route('admin.guru.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    /**
     * Hapus data guru.
     */
    public function destroyGuru(Guru $guru): RedirectResponse
    {
        $guru->user?->delete();
        $guru->delete();

        return redirect()
            ->route('admin.guru.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }

    // ============================================================
    // NILAI — Admin dapat melihat, mengedit, dan menghapus nilai
    // ============================================================

    /**
     * Daftar semua nilai.
     */
    public function indexNilai(): View
    {
        $nilais = Nilai::with(['siswa', 'guru'])->latest()->paginate(15);

        return view('admin.nilai.index', compact('nilais'));
    }

    /**
     * Form tambah nilai (oleh admin).
     */
    public function createNilai(): View
    {
        $siswas = Siswa::orderBy('nama')->get();
        $gurus = Guru::orderBy('nama')->get();

        return view('admin.nilai.create', compact('siswas', 'gurus'));
    }

    /**
     * Simpan nilai baru.
     */
    public function storeNilai(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'siswa_id' => ['required', 'exists:siswas,id'],
            'guru_id' => ['required', 'exists:gurus,id'],
            'mata_pelajaran' => ['required', 'string', 'max:100'],
            'nilai_tugas' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_uts' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_uas' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        // Gunakan NilaiHelper untuk perhitungan
        $nilaiAkhir = NilaiHelper::hitungNilaiAkhir(
            $validated['nilai_tugas'],
            $validated['nilai_uts'],
            $validated['nilai_uas']
        );

        Nilai::create([
            'siswa_id' => $validated['siswa_id'],
            'guru_id' => $validated['guru_id'],
            'mata_pelajaran' => $validated['mata_pelajaran'],
            'nilai_tugas' => $validated['nilai_tugas'],
            'nilai_uts' => $validated['nilai_uts'],
            'nilai_uas' => $validated['nilai_uas'],
            'nilai_akhir' => $nilaiAkhir,
            'status' => NilaiHelper::tentukanStatusKelulusan($nilaiAkhir),
        ]);

        return redirect()
            ->route('admin.nilai.index')
            ->with('success', 'Data nilai berhasil ditambahkan.');
    }

    /**
     * Form edit nilai.
     */
    public function editNilai(Nilai $nilai): View
    {
        $siswas = Siswa::orderBy('nama')->get();
        $gurus = Guru::orderBy('nama')->get();

        return view('admin.nilai.edit', compact('nilai', 'siswas', 'gurus'));
    }

    /**
     * Update nilai.
     */
    public function updateNilai(Request $request, Nilai $nilai): RedirectResponse
    {
        $validated = $request->validate([
            'siswa_id' => ['required', 'exists:siswas,id'],
            'guru_id' => ['required', 'exists:gurus,id'],
            'mata_pelajaran' => ['required', 'string', 'max:100'],
            'nilai_tugas' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_uts' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_uas' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        $nilaiAkhir = NilaiHelper::hitungNilaiAkhir(
            $validated['nilai_tugas'],
            $validated['nilai_uts'],
            $validated['nilai_uas']
        );

        $nilai->update([
            'siswa_id' => $validated['siswa_id'],
            'guru_id' => $validated['guru_id'],
            'mata_pelajaran' => $validated['mata_pelajaran'],
            'nilai_tugas' => $validated['nilai_tugas'],
            'nilai_uts' => $validated['nilai_uts'],
            'nilai_uas' => $validated['nilai_uas'],
            'nilai_akhir' => $nilaiAkhir,
            'status' => NilaiHelper::tentukanStatusKelulusan($nilaiAkhir),
        ]);

        return redirect()
            ->route('admin.nilai.index')
            ->with('success', 'Data nilai berhasil diperbarui.');
    }

    /**
     * Hapus nilai.
     */
    public function destroyNilai(Nilai $nilai): RedirectResponse
    {
        $nilai->delete();

        return redirect()
            ->route('admin.nilai.index')
            ->with('success', 'Data nilai berhasil dihapus.');
    }
}
