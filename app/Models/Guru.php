<?php

namespace App\Models;

use App\Helpers\NilaiHelper;
use Database\Factories\GuruFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['kode_guru', 'nama', 'mata_pelajaran', 'user_id'])]
class Guru extends Model
{
    /** @use HasFactory<GuruFactory> */
    use HasFactory;

    protected $table = 'gurus';

    /**
     * Relasi ke user (akun login guru).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke semua nilai yang diinput oleh guru ini.
     */
    public function nilais(): HasMany
    {
        return $this->hasMany(Nilai::class);
    }

    /**
     * Method OOP: Menginput nilai untuk seorang siswa.
     * Menggunakan fungsi terstruktur NilaiHelper untuk perhitungan.
     *
     * @param  float  $nilaiTugas  Nilai Tugas (0-100)
     * @param  float  $nilaiUts    Nilai UTS (0-100)
     * @param  float  $nilaiUas    Nilai UAS (0-100)
     */
    public function inputNilai(Siswa $siswa, float $nilaiTugas, float $nilaiUts, float $nilaiUas): Nilai
    {
        return $this->nilais()->updateOrCreate(
            [
                'siswa_id' => $siswa->id,
                'mata_pelajaran' => $this->mata_pelajaran,
            ],
            [
                'nilai_tugas' => $nilaiTugas,
                'nilai_uts' => $nilaiUts,
                'nilai_uas' => $nilaiUas,
                'nilai_akhir' => NilaiHelper::hitungNilaiAkhir($nilaiTugas, $nilaiUts, $nilaiUas),
                'status' => NilaiHelper::tentukanStatusKelulusan(
                    NilaiHelper::hitungNilaiAkhir($nilaiTugas, $nilaiUts, $nilaiUas)
                ),
            ]
        );
    }

    /**
     * Method OOP: Memvalidasi nilai dalam rentang 0-100.
     * Delegasi ke fungsi terstruktur NilaiHelper.
     */
    public function validasiNilai(float $nilai): bool
    {
        return NilaiHelper::validasiNilai($nilai);
    }

    /**
     * Method OOP: Mendapatkan rekap nilai untuk mata pelajaran guru.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getRekapNilai(): array
    {
        return $this->nilais()
            ->with('siswa')
            ->get()
            ->map(fn (Nilai $nilai) => [
                'siswa' => $nilai->siswa->nama,
                'nis' => $nilai->siswa->nis,
                'kelas' => $nilai->siswa->kelas,
                'mata_pelajaran' => $nilai->mata_pelajaran,
                'nilai_tugas' => $nilai->nilai_tugas,
                'nilai_uts' => $nilai->nilai_uts,
                'nilai_uas' => $nilai->nilai_uas,
                'nilai_akhir' => $nilai->nilai_akhir,
                'status' => $nilai->status,
            ])
            ->toArray();
    }
}
