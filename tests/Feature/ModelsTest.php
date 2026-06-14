<?php

use App\Helpers\NilaiHelper;
use App\Models\Guru;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\User;

use function Pest\Laravel\mock;

// ============================================================
// PENGUJIAN OOP — MODEL SISWA
// ============================================================

it('dapat membuat data siswa lengkap', function () {
    $siswa = Siswa::factory()->create([
        'nis' => 'NIS-99999',
        'nama' => 'Test Siswa',
        'kelas' => 'X IPA 1',
    ]);

    expect($siswa->nis)->toBe('NIS-99999');
    expect($siswa->nama)->toBe('Test Siswa');
    expect($siswa->kelas)->toBe('X IPA 1');
});

it('memiliki relasi ke user', function () {
    $user = User::factory()->siswa()->create();
    $siswa = Siswa::factory()->create(['user_id' => $user->id]);

    expect($siswa->user)->not->toBeNull();
    expect($siswa->user->role)->toBe('siswa');
});

it('memiliki relasi ke nilai-nilai', function () {
    $siswa = Siswa::factory()->create();
    Nilai::factory()->count(3)->create(['siswa_id' => $siswa->id]);

    expect($siswa->nilais)->toHaveCount(3);
});

it('menghitung rata-rata nilai akhir', function () {
    $siswa = Siswa::factory()->create();
    Nilai::factory()->create(['siswa_id' => $siswa->id, 'nilai_tugas' => 80, 'nilai_uts' => 75, 'nilai_uas' => 85]);
    Nilai::factory()->create(['siswa_id' => $siswa->id, 'nilai_tugas' => 70, 'nilai_uts' => 70, 'nilai_uas' => 70]);

    $rata = $siswa->getRataRataNilaiAkhir();
    $na1 = NilaiHelper::hitungNilaiAkhir(80, 75, 85); // 80.5
    $na2 = NilaiHelper::hitungNilaiAkhir(70, 70, 70); // 70.0
    $expected = round(($na1 + $na2) / 2, 2);

    expect($rata)->toBe($expected);
});

it('rata-rata nol jika tidak ada nilai', function () {
    $siswa = Siswa::factory()->create();

    expect($siswa->getRataRataNilaiAkhir())->toBe(0.0);
});

it('menentukan status kelulusan berdasarkan rata-rata', function () {
    $siswa = Siswa::factory()->create();

    // Nilai di atas 70
    Nilai::factory()->create(['siswa_id' => $siswa->id, 'nilai_tugas' => 80, 'nilai_uts' => 80, 'nilai_uas' => 80]);
    expect($siswa->getStatusKelulusan())->toBe('Lulus');
});

it('menghasilkan laporan lengkap', function () {
    $siswa = Siswa::factory()->create(['nis' => 'NIS-REPORT', 'nama' => 'Report Siswa', 'kelas' => 'XII IPA 1']);
    Nilai::factory()->count(2)->create(['siswa_id' => $siswa->id]);

    $laporan = $siswa->getLaporan();

    expect($laporan)->toHaveKeys(['nis', 'nama', 'kelas', 'nilai_per_mapel', 'rata_rata', 'status_kelulusan']);
    expect($laporan['nis'])->toBe('NIS-REPORT');
    expect($laporan['nilai_per_mapel'])->toHaveCount(2);
});

// --- MODEL GURU (OOP) ---

it('dapat membuat data guru lengkap', function () {
    $guru = Guru::factory()->create([
        'kode_guru' => 'GRU-TEST',
        'nama' => 'Test Guru',
        'mata_pelajaran' => 'Fisika',
    ]);

    expect($guru->kode_guru)->toBe('GRU-TEST');
    expect($guru->mata_pelajaran)->toBe('Fisika');
});

it('guru dapat menginput nilai siswa', function () {
    $guru = Guru::factory()->create(['mata_pelajaran' => 'Matematika']);
    $siswa = Siswa::factory()->create();

    $nilai = $guru->inputNilai($siswa, 80, 75, 85);

    expect($nilai)->toBeInstanceOf(Nilai::class);
    expect($nilai->siswa_id)->toBe($siswa->id);
    expect($nilai->mata_pelajaran)->toBe('Matematika');
    expect($nilai->nilai_akhir)->toBe(80.5);
});

it('guru dapat memvalidasi nilai', function () {
    $guru = Guru::factory()->create();

    expect($guru->validasiNilai(50))->toBeTrue();
    expect($guru->validasiNilai(-10))->toBeFalse();
});

it('guru memiliki rekap nilai', function () {
    $guru = Guru::factory()->create(['mata_pelajaran' => 'Matematika']);
    $siswa = Siswa::factory()->create();
    $guru->inputNilai($siswa, 80, 80, 80);

    $rekap = $guru->getRekapNilai();

    expect($rekap)->toHaveCount(1);
    expect($rekap[0]['mata_pelajaran'])->toBe('Matematika');
});

// --- MODEL NILAI (OOP) ---

it('nilai otomatis dihitung saat disimpan', function () {
    $siswa = Siswa::factory()->create();
    $guru = Guru::factory()->create();

    $nilai = Nilai::create([
        'siswa_id' => $siswa->id,
        'guru_id' => $guru->id,
        'mata_pelajaran' => 'Test',
        'nilai_tugas' => 80,
        'nilai_uts' => 75,
        'nilai_uas' => 85,
    ]);

    expect($nilai->nilai_akhir)->toBe(80.5);
    expect($nilai->status)->toBe('Lulus');
});

it('nilai memiliki relasi ke siswa dan guru', function () {
    $siswa = Siswa::factory()->create();
    $guru = Guru::factory()->create();
    $nilai = Nilai::factory()->create(['siswa_id' => $siswa->id, 'guru_id' => $guru->id]);

    expect($nilai->siswa)->not->toBeNull();
    expect($nilai->guru)->not->toBeNull();
});

// --- MODEL USER ---

it('user memiliki method cek role', function () {
    $admin = User::factory()->admin()->create();
    $guru = User::factory()->guru()->create();
    $siswa = User::factory()->siswa()->create();

    expect($admin->isAdmin())->toBeTrue();
    expect($admin->isGuru())->toBeFalse();
    expect($guru->isGuru())->toBeTrue();
    expect($siswa->isSiswa())->toBeTrue();
});

it('user memiliki relasi ke data spesifik role', function () {
    $user = User::factory()->guru()->create();
    Guru::factory()->create(['user_id' => $user->id]);

    expect($user->guru)->not->toBeNull();
    expect($user->siswa)->toBeNull();
});
