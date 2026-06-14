<?php

namespace App\Helpers;

/**
 * NilaiHelper — Implementasi Pemrograman Terstruktur
 *
 * Kelas ini berisi fungsi/prosedur statis yang menangani logika
 * pengolahan nilai menggunakan pendekatan pemrograman terstruktur.
 * Fungsi-fungsi ini digunakan oleh model OOP (Siswa, Guru, Nilai)
 * untuk menunjukkan integrasi kedua paradigma.
 */
class NilaiHelper
{
    /**
     * Batas nilai minimum yang valid.
     */
    public const NILAI_MIN = 0;

    /**
     * Batas nilai maksimum yang valid.
     */
    public const NILAI_MAX = 100;

    /**
     * Bobot nilai tugas dalam perhitungan nilai akhir (30%).
     */
    public const BOBOT_TUGAS = 0.30;

    /**
     * Bobot nilai UTS dalam perhitungan nilai akhir (30%).
     */
    public const BOBOT_UTS = 0.30;

    /**
     * Bobot nilai UAS dalam perhitungan nilai akhir (40%).
     */
    public const BOBOT_UAS = 0.40;

    /**
     * Ambang batas nilai kelulusan.
     */
    public const NILAI_LULUS = 70;

    /**
     * FUNGSI 1: Validasi Nilai
     *
     * Memvalidasi apakah sebuah nilai berada dalam rentang yang valid (0-100).
     * Fungsi ini memisahkan logika validasi dari logika bisnis lainnya,
     * memungkinkan validasi digunakan di berbagai komponen sistem.
     *
     * @param  float  $nilai  Nilai yang akan divalidasi
     * @return bool           True jika nilai valid, false jika tidak
     */
    public static function validasiNilai(float $nilai): bool
    {
        return $nilai >= self::NILAI_MIN && $nilai <= self::NILAI_MAX;
    }

    /**
     * FUNGSI 2: Perhitungan Nilai Akhir
     *
     * Menghitung nilai akhir berdasarkan rumus:
     *   Nilai Akhir = (30% × Tugas) + (30% × UTS) + (40% × UAS)
     *
     * Fungsi ini mengenkapsulasi rumus perhitungan sehingga jika rumus
     * berubah, hanya perlu diubah di satu tempat. Sebelum menghitung,
     * fungsi melakukan validasi terhadap setiap komponen nilai.
     *
     * @param  float  $nilaiTugas  Nilai Tugas (0-100)
     * @param  float  $nilaiUts    Nilai UTS (0-100)
     * @param  float  $nilaiUas    Nilai UAS (0-100)
     * @return float               Nilai akhir hasil perhitungan
     *
     * @throws \InvalidArgumentException Jika nilai tidak valid
     */
    public static function hitungNilaiAkhir(float $nilaiTugas, float $nilaiUts, float $nilaiUas): float
    {
        if (! self::validasiNilai($nilaiTugas)) {
            throw new \InvalidArgumentException("Nilai Tugas tidak valid: {$nilaiTugas}. Rentang nilai: 0-100.");
        }

        if (! self::validasiNilai($nilaiUts)) {
            throw new \InvalidArgumentException("Nilai UTS tidak valid: {$nilaiUts}. Rentang nilai: 0-100.");
        }

        if (! self::validasiNilai($nilaiUas)) {
            throw new \InvalidArgumentException("Nilai UAS tidak valid: {$nilaiUas}. Rentang nilai: 0-100.");
        }

        $nilaiAkhir = (self::BOBOT_TUGAS * $nilaiTugas)
                    + (self::BOBOT_UTS * $nilaiUts)
                    + (self::BOBOT_UAS * $nilaiUas);

        return round($nilaiAkhir, 2);
    }

    /**
     * FUNGSI 3: Penentuan Status Kelulusan
     *
     * Menentukan status kelulusan berdasarkan nilai akhir.
     * Siswa dinyatakan LULUS jika nilai akhir >= 70.
     * Fungsi ini memisahkan logika penentuan kelulusan agar dapat
     * digunakan secara konsisten di seluruh sistem.
     *
     * @param  float  $nilaiAkhir  Nilai akhir siswa
     * @return string              'Lulus' atau 'Tidak Lulus'
     */
    public static function tentukanStatusKelulusan(float $nilaiAkhir): string
    {
        return $nilaiAkhir >= self::NILAI_LULUS ? 'Lulus' : 'Tidak Lulus';
    }

    /**
     * FUNGSI 4: Pengolahan Laporan
     *
     * Menghasilkan ringkasan statistik dari kumpulan nilai siswa.
     * Fungsi ini menunjukkan pemrograman terstruktur dalam pengolahan
     * data agregat untuk keperluan pelaporan.
     *
     * @param  array<int, array{nilai_akhir: float, status: string}>  $dataNilai  Array data nilai
     * @return array{total_siswa: int, lulus: int, tidak_lulus: int, nilai_tertinggi: float, nilai_terendah: float, rata_rata: float}
     */
    public static function generateLaporan(array $dataNilai): array
    {
        if (empty($dataNilai)) {
            return [
                'total_siswa' => 0,
                'lulus' => 0,
                'tidak_lulus' => 0,
                'nilai_tertinggi' => 0,
                'nilai_terendah' => 0,
                'rata_rata' => 0,
            ];
        }

        $nilaiAkhirList = array_column($dataNilai, 'nilai_akhir');

        $totalSiswa = count($dataNilai);
        $lulus = count(array_filter($dataNilai, fn (array $n): bool => $n['status'] === 'Lulus'));
        $tidakLulus = $totalSiswa - $lulus;
        $nilaiTertinggi = max($nilaiAkhirList);
        $nilaiTerendah = min($nilaiAkhirList);
        $rataRata = round(array_sum($nilaiAkhirList) / $totalSiswa, 2);

        return [
            'total_siswa' => $totalSiswa,
            'lulus' => $lulus,
            'tidak_lulus' => $tidakLulus,
            'nilai_tertinggi' => $nilaiTertinggi,
            'nilai_terendah' => $nilaiTerendah,
            'rata_rata' => $rataRata,
        ];
    }
}
