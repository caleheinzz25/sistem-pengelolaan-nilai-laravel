<?php

namespace App\Models;

use App\Helpers\NilaiHelper;
use Database\Factories\NilaiFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'siswa_id',
    'guru_id',
    'mata_pelajaran',
    'nilai_tugas',
    'nilai_uts',
    'nilai_uas',
    'nilai_akhir',
    'status',
])]
class Nilai extends Model
{
    /** @use HasFactory<NilaiFactory> */
    use HasFactory;

    protected $table = 'nilais';

    /**
     * Cast atribut ke tipe data yang sesuai.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'nilai_tugas' => 'float',
            'nilai_uts' => 'float',
            'nilai_uas' => 'float',
            'nilai_akhir' => 'float',
        ];
    }

    /**
     * Relasi ke data siswa.
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    /**
     * Relasi ke data guru yang menginput nilai.
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    /**
     * Method OOP: Menghitung ulang nilai akhir.
     * Menggunakan fungsi terstruktur NilaiHelper.
     */
    public function hitungNilaiAkhir(): float
    {
        $this->nilai_akhir = NilaiHelper::hitungNilaiAkhir(
            $this->nilai_tugas,
            $this->nilai_uts,
            $this->nilai_uas
        );
        $this->status = NilaiHelper::tentukanStatusKelulusan($this->nilai_akhir);

        return $this->nilai_akhir;
    }

    /**
     * Method OOP: Menentukan status kelulusan.
     */
    public function tentukanStatus(): string
    {
        $this->status = NilaiHelper::tentukanStatusKelulusan($this->nilai_akhir);

        return $this->status;
    }

    /**
     * Boot model — otomatis hitung nilai akhir dan status sebelum menyimpan.
     */
    protected static function booted(): void
    {
        static::saving(function (Nilai $nilai) {
            $nilai->nilai_akhir = NilaiHelper::hitungNilaiAkhir(
                $nilai->nilai_tugas,
                $nilai->nilai_uts,
                $nilai->nilai_uas
            );
            $nilai->status = NilaiHelper::tentukanStatusKelulusan($nilai->nilai_akhir);
        });
    }
}
