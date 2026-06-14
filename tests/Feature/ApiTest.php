<?php

use App\Models\Guru;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

// ============================================================
// PENGUJIAN API
// ============================================================

it('guest tidak dapat mengakses API yang memerlukan autentikasi', function () {
    $this->getJson('/api/user')
        ->assertUnauthorized();
});

it('user dapat login melalui API', function () {
    $user = User::factory()->admin()->create(['email' => 'api@test.com']);

    postJson('/api/login', [
        'email' => 'api@test.com',
        'password' => 'password',
    ])
        ->assertSuccessful()
        ->assertJsonPath('user.email', 'api@test.com');

    $this->assertAuthenticated();
});

it('login API gagal dengan kredensial salah', function () {
    User::factory()->create(['email' => 'api@test.com']);

    postJson('/api/login', [
        'email' => 'api@test.com',
        'password' => 'wrong-password',
    ])
        ->assertUnauthorized();
});

it('admin dapat mengakses dashboard API', function () {
    $user = User::factory()->admin()->create();

    actingAs($user)
        ->getJson('/api/admin/dashboard')
        ->assertSuccessful()
        ->assertJsonStructure(['total_siswa', 'total_guru', 'total_nilai', 'statistik']);
});

it('admin dapat melihat daftar siswa via API', function () {
    $user = User::factory()->admin()->create();
    Siswa::factory()->count(5)->create();

    actingAs($user)
        ->getJson('/api/admin/siswa')
        ->assertSuccessful()
        ->assertJsonCount(5, 'data');
});

it('admin dapat membuat siswa baru via API', function () {
    $user = User::factory()->admin()->create();

    actingAs($user)
        ->postJson('/api/admin/siswa', [
            'nis' => 'NIS-99999',
            'nama' => 'Siswa API',
            'kelas' => 'X IPA 1',
            'email' => 'siswaapi@test.com',
            'password' => 'password',
        ])
        ->assertCreated()
        ->assertJsonPath('data.nis', 'NIS-99999');

    $this->assertDatabaseHas('siswas', ['nis' => 'NIS-99999']);
});

it('guru dapat mengakses dashboard dan rekap via API', function () {
    $user = User::factory()->guru()->create();
    $guru = Guru::factory()->create(['user_id' => $user->id]);
    $siswa = Siswa::factory()->create();
    Nilai::factory()->create(['guru_id' => $guru->id, 'siswa_id' => $siswa->id]);

    actingAs($user)
        ->getJson('/api/guru/dashboard')
        ->assertSuccessful()
        ->assertJsonPath('guru.id', $guru->id);

    actingAs($user)
        ->getJson('/api/guru/rekap')
        ->assertSuccessful()
        ->assertJsonCount(1, 'rekap');
});

it('siswa dapat melihat nilai via API', function () {
    $user = User::factory()->siswa()->create();
    $siswa = Siswa::factory()->create(['user_id' => $user->id]);

    actingAs($user)
        ->getJson('/api/siswa/dashboard')
        ->assertSuccessful()
        ->assertJsonPath('data.nis', $siswa->nis);
});
