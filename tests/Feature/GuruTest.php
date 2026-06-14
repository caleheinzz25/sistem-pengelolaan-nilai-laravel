<?php

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

// ============================================================
// PENGUJIAN FITUR GURU
// ============================================================

beforeEach(function () {
    $this->user = User::factory()->guru()->create();
    $this->guru = Guru::factory()->create([
        'user_id' => $this->user->id,
        'mata_pelajaran' => 'Matematika',
    ]);
});

it('guru dapat mengakses dashboard', function () {
    actingAs($this->user)
        ->get(route('guru.dashboard'))
        ->assertSuccessful()
        ->assertSee('Dashboard Guru');
});

it('guru dapat melihat form input nilai', function () {
    Siswa::factory()->create();

    actingAs($this->user)
        ->get(route('guru.input-nilai'))
        ->assertSuccessful()
        ->assertSee('Input Nilai Siswa');
});

it('guru dapat menyimpan nilai untuk siswa', function () {
    $siswa = Siswa::factory()->create();

    actingAs($this->user)
        ->post(route('guru.store-nilai'), [
            'siswa_id' => $siswa->id,
            'nilai_tugas' => 80,
            'nilai_uts' => 75,
            'nilai_uas' => 85,
        ])
        ->assertRedirect(route('guru.rekap'));

    assertDatabaseHas('nilais', [
        'siswa_id' => $siswa->id,
        'guru_id' => $this->guru->id,
        'mata_pelajaran' => 'Matematika',
        'nilai_akhir' => 80.5,
        'status' => 'Lulus',
    ]);
});

it('guru dapat mengupdate nilai siswa yang sudah ada', function () {
    $siswa = Siswa::factory()->create();

    // Input pertama
    actingAs($this->user)
        ->post(route('guru.store-nilai'), [
            'siswa_id' => $siswa->id,
            'nilai_tugas' => 80,
            'nilai_uts' => 75,
            'nilai_uas' => 85,
        ]);

    // Update nilai
    actingAs($this->user)
        ->post(route('guru.store-nilai'), [
            'siswa_id' => $siswa->id,
            'nilai_tugas' => 60,
            'nilai_uts' => 55,
            'nilai_uas' => 50,
        ]);

    // Harus tetap 1 record (update), bukan 2
    expect($this->guru->nilais()->count())->toBe(1);
    assertDatabaseHas('nilais', [
        'siswa_id' => $siswa->id,
        'guru_id' => $this->guru->id,
        'nilai_akhir' => 54.5,
        'status' => 'Tidak Lulus',
    ]);
});

it('guru dapat melihat rekap nilai', function () {
    $siswa = Siswa::factory()->create();
    $this->guru->inputNilai($siswa, 80, 80, 80);

    actingAs($this->user)
        ->get(route('guru.rekap'))
        ->assertSuccessful()
        ->assertSee('Rekap Nilai');
});

it('validasi nilai input guru dalam rentang 0-100', function () {
    $siswa = Siswa::factory()->create();

    actingAs($this->user)
        ->post(route('guru.store-nilai'), [
            'siswa_id' => $siswa->id,
            'nilai_tugas' => 150,
            'nilai_uts' => 50,
            'nilai_uas' => 50,
        ])
        ->assertSessionHasErrors('nilai_tugas');
});
