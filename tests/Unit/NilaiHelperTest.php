<?php

use App\Helpers\NilaiHelper;

// ============================================================
// PENGUJIAN PEMROGRAMAN TERSTRUKTUR — NilaiHelper
// ============================================================

// --- FUNGSI 1: validasiNilai ---
it('memvalidasi nilai dalam rentang 0-100', function (float $nilai, bool $expected) {
    expect(NilaiHelper::validasiNilai($nilai))->toBe($expected);
})->with([
    'batas bawah valid' => [0, true],
    'batas atas valid' => [100, true],
    'nilai tengah valid' => [75.5, true],
    'negatif tidak valid' => [-1, false],
    'di atas 100 tidak valid' => [101, false],
    'jauh di atas 100' => [150, false],
]);

// --- FUNGSI 2: hitungNilaiAkhir ---
dataset('perhitungan_nilai', [
    'nilai sempurna' => [100, 100, 100, 100.0],
    'nilai minimal' => [0, 0, 0, 0.0],
    'nilai campuran' => [80, 75, 85, 80.5],
    'nilai tengah' => [70, 70, 70, 70.0],
    'bobot UAS dominan' => [60, 60, 100, 76.0],
    'bobot Tugas dominan' => [100, 60, 60, 72.0],
]);

it('menghitung nilai akhir dengan benar', function (float $tugas, float $uts, float $uas, float $expected) {
    expect(NilaiHelper::hitungNilaiAkhir($tugas, $uts, $uas))->toBe($expected);
})->with('perhitungan_nilai');

it('melempar exception untuk nilai tugas tidak valid', function () {
    NilaiHelper::hitungNilaiAkhir(-5, 50, 50);
})->throws(InvalidArgumentException::class);

it('melempar exception untuk nilai UTS tidak valid', function () {
    NilaiHelper::hitungNilaiAkhir(50, 150, 50);
})->throws(InvalidArgumentException::class);

it('melempar exception untuk nilai UAS tidak valid', function () {
    NilaiHelper::hitungNilaiAkhir(50, 50, 200);
})->throws(InvalidArgumentException::class);

// --- FUNGSI 3: tentukanStatusKelulusan ---
it('menentukan status lulus jika nilai akhir >= 70', function () {
    expect(NilaiHelper::tentukanStatusKelulusan(70))->toBe('Lulus');
    expect(NilaiHelper::tentukanStatusKelulusan(85.5))->toBe('Lulus');
    expect(NilaiHelper::tentukanStatusKelulusan(100))->toBe('Lulus');
});

it('menentukan status tidak lulus jika nilai akhir < 70', function () {
    expect(NilaiHelper::tentukanStatusKelulusan(69.99))->toBe('Tidak Lulus');
    expect(NilaiHelper::tentukanStatusKelulusan(50))->toBe('Tidak Lulus');
    expect(NilaiHelper::tentukanStatusKelulusan(0))->toBe('Tidak Lulus');
});

// --- FUNGSI 4: generateLaporan ---
it('menghasilkan laporan statistik dari data nilai', function () {
    $data = [
        ['nilai_akhir' => 80, 'status' => 'Lulus'],
        ['nilai_akhir' => 60, 'status' => 'Tidak Lulus'],
        ['nilai_akhir' => 90, 'status' => 'Lulus'],
        ['nilai_akhir' => 55, 'status' => 'Tidak Lulus'],
    ];

    $laporan = NilaiHelper::generateLaporan($data);

    expect($laporan['total_siswa'])->toBe(4);
    expect($laporan['lulus'])->toBe(2);
    expect($laporan['tidak_lulus'])->toBe(2);
    expect((float) $laporan['nilai_tertinggi'])->toBe(90.0);
    expect((float) $laporan['nilai_terendah'])->toBe(55.0);
    expect($laporan['rata_rata'])->toBe(71.25);
});

it('menghasilkan laporan kosong untuk data kosong', function () {
    $laporan = NilaiHelper::generateLaporan([]);

    expect($laporan['total_siswa'])->toBe(0);
    expect($laporan['lulus'])->toBe(0);
});

// --- Pengujian konstanta ---
it('memiliki konstanta bobot yang benar', function () {
    expect(NilaiHelper::BOBOT_TUGAS)->toBe(0.30);
    expect(NilaiHelper::BOBOT_UTS)->toBe(0.30);
    expect(NilaiHelper::BOBOT_UAS)->toBe(0.40);
    expect(NilaiHelper::NILAI_LULUS)->toBe(70);
    expect(NilaiHelper::NILAI_MIN)->toBe(0);
    expect(NilaiHelper::NILAI_MAX)->toBe(100);
});
