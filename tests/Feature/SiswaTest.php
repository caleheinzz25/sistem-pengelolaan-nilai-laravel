<?php

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\User;

use function Pest\Laravel\actingAs;

// ============================================================
// PENGUJIAN FITUR SISWA
// ============================================================

beforeEach(function () {
    $this->user = User::factory()->siswa()->create(['name' => 'Test Siswa']);
    $this->siswa = Siswa::factory()->create([
        'user_id' => $this->user->id,
        'nis' => 'NIS-TEST',
        'nama' => 'Test Siswa',
        'kelas' => 'X IPA 1',
    ]);
});

it('siswa dapat melihat dashboard dan nilai pribadi', function () {
    actingAs($this->user)
        ->get(route('siswa.dashboard'))
        ->assertSuccessful()
        ->assertSee('Nilai Saya')
        ->assertSee('Test Siswa')
        ->assertSee('NIS-TEST');
});

it('siswa melihat status tidak lulus jika rata-rata < 70', function () {
    Nilai::factory()->create([
        'siswa_id' => $this->siswa->id,
        'nilai_tugas' => 50,
        'nilai_uts' => 50,
        'nilai_uas' => 50, // nilai_akhir = 50
    ]);

    actingAs($this->user)
        ->get(route('siswa.dashboard'))
        ->assertSee('Tidak Lulus');
});

it('siswa melihat status lulus jika rata-rata >= 70', function () {
    Nilai::factory()->create([
        'siswa_id' => $this->siswa->id,
        'nilai_tugas' => 80,
        'nilai_uts' => 80,
        'nilai_uas' => 80, // nilai_akhir = 80
    ]);

    actingAs($this->user)
        ->get(route('siswa.dashboard'))
        ->assertSee('Lulus');
});

it('siswa melihat tabel nilai per mata pelajaran', function () {
    Nilai::factory()->create([
        'siswa_id' => $this->siswa->id,
        'mata_pelajaran' => 'Matematika',
        'nilai_tugas' => 80,
        'nilai_uts' => 75,
        'nilai_uas' => 85,
    ]);

    actingAs($this->user)
        ->get(route('siswa.dashboard'))
        ->assertSee('Matematika');
});

it('siswa tidak dapat mengakses halaman admin', function () {
    actingAs($this->user)
        ->get('/admin/dashboard')
        ->assertForbidden();
});

it('siswa tidak dapat mengakses halaman guru', function () {
    actingAs($this->user)
        ->get('/guru/dashboard')
        ->assertForbidden();
});
