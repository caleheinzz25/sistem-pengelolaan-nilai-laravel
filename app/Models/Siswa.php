<?php

namespace App\Models;

use App\Helpers\NilaiHelper;
use Database\Factories\SiswaFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nis', 'nama', 'kelas', 'user_id'])]
class Siswa extends Model
{
    /** @use HasFactory<SiswaFactory> */
    use HasFactory;

    protected $table = 'siswas';

    /**
     * Relasi ke user (akun login siswa).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke semua data nilai siswa.
     */
    public function nilais(): HasMany
    {
        return $this->hasMany(Nilai::class);
    }

    /**
     * Method OOP: Menghitung rata-rata nilai akhir dari semua mata pelajaran.
     */
    public function getRataRataNilaiAkhir(): float
    {
        $nilais = $this->nilais;

        if ($nilais->isEmpty()) {
            return 0;
        }

        return round((float) $nilais->avg('nilai_akhir'), 2);
    }

    /**
     * Method OOP: Menentukan status kelulusan siswa secara keseluruhan.
     * Menggunakan fungsi terstruktur NilaiHelper untuk konsistensi.
     */
    public function getStatusKelulusan(): string
    {
        return NilaiHelper::tentukanStatusKelulusan($this->getRataRataNilaiAkhir());
    }

    /**
     * Method OOP: Mendapatkan laporan lengkap nilai siswa.
     *
     * @return array<string, mixed>
     */
    public function getLaporan(): array
    {
        return [
            'nis' => $this->nis,
            'nama' => $this->nama,
            'kelas' => $this->kelas,
            'nilai_per_mapel' => $this->nilais->map(fn (Nilai $nilai) => [
                'mata_pelajaran' => $nilai->mata_pelajaran,
                'nilai_tugas' => $nilai->nilai_tugas,
                'nilai_uts' => $nilai->nilai_uts,
                'nilai_uas' => $nilai->nilai_uas,
                'nilai_akhir' => $nilai->nilai_akhir,
                'status' => $nilai->status,
            ]),
            'rata_rata' => $this->getRataRataNilaiAkhir(),
            'status_kelulusan' => $this->getStatusKelulusan(),
        ];
    }
}
