<?php

namespace Database\Factories;

use App\Helpers\NilaiHelper;
use App\Models\Guru;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Nilai>
 */
class NilaiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nilaiTugas = fake()->numberBetween(40, 100);
        $nilaiUts = fake()->numberBetween(40, 100);
        $nilaiUas = fake()->numberBetween(40, 100);
        $nilaiAkhir = NilaiHelper::hitungNilaiAkhir($nilaiTugas, $nilaiUts, $nilaiUas);

        return [
            'siswa_id' => Siswa::factory(),
            'guru_id' => Guru::factory(),
            'mata_pelajaran' => fake()->randomElement([
                'Matematika', 'Bahasa Indonesia', 'Bahasa Inggris',
                'Fisika', 'Kimia', 'Biologi',
            ]),
            'nilai_tugas' => $nilaiTugas,
            'nilai_uts' => $nilaiUts,
            'nilai_uas' => $nilaiUas,
            'nilai_akhir' => $nilaiAkhir,
            'status' => NilaiHelper::tentukanStatusKelulusan($nilaiAkhir),
        ];
    }
}
