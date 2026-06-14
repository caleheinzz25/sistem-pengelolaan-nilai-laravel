<?php

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

// ============================================================
// PENGUJIAN FITUR LAPORAN
// ============================================================

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
    $this->siswa = Siswa::factory()->create(['nis' => 'NIS-LAP', 'nama' => 'Lap Siswa', 'kelas' => 'X IPA 1']);
    $guru = \App\Models\Guru::factory()->create(['mata_pelajaran' => 'Matematika']);

    Nilai::factory()->create([
        'siswa_id' => $this->siswa->id,
        'guru_id' => $guru->id,
        'mata_pelajaran' => 'Matematika',
        'nilai_tugas' => 80,
        'nilai_uts' => 75,
        'nilai_uas' => 85, // 80.5
    ]);
});

it('admin dapat mengakses halaman laporan', function () {
    actingAs($this->admin)
        ->get(route('admin.laporan.index'))
        ->assertSuccessful()
        ->assertSee('Laporan Hasil Nilai Siswa');
});

it('admin dapat melihat detail laporan per siswa', function () {
    actingAs($this->admin)
        ->get(route('admin.laporan.show', $this->siswa))
        ->assertSuccessful()
        ->assertSee('NIS-LAP')
        ->assertSee('Lap Siswa');
});

it('laporan menampilkan statistik global', function () {
    actingAs($this->admin)
        ->get(route('admin.laporan.index'))
        ->assertSee('Total')
        ->assertSee('Lulus');
});

it('admin dapat mencetak laporan', function () {
    actingAs($this->admin)
        ->get(route('admin.laporan.print'))
        ->assertSuccessful()
        ->assertSee('LAPORAN HASIL NILAI SISWA');
});

it('laporan hanya dapat diakses admin', function () {
    $guru = User::factory()->guru()->create();

    actingAs($guru)
        ->get(route('admin.laporan.index'))
        ->assertForbidden();
});
