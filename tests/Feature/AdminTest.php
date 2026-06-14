<?php

use App\Models\Siswa;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

// ============================================================
// PENGUJIAN FITUR ADMIN - CRUD SISWA
// ============================================================

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
});

it('admin dapat melihat daftar siswa', function () {
    Siswa::factory()->count(3)->create();

    actingAs($this->admin)
        ->get(route('admin.siswa.index'))
        ->assertSuccessful()
        ->assertSee('Data Siswa');
});

it('admin dapat menambah siswa', function () {
    actingAs($this->admin)
        ->post(route('admin.siswa.store'), [
            'nis' => 'NIS-BARU',
            'nama' => 'Siswa Baru',
            'kelas' => 'X IPA 1',
        ])
        ->assertRedirect(route('admin.siswa.index'));

    assertDatabaseHas('siswas', ['nis' => 'NIS-BARU', 'nama' => 'Siswa Baru']);
    // Harus membuat user account juga
    expect(User::where('role', 'siswa')->count())->toBeGreaterThan(0);
});

it('admin dapat mengedit siswa', function () {
    $siswa = Siswa::factory()->create(['nis' => 'NIS-OLD']);

    actingAs($this->admin)
        ->put(route('admin.siswa.update', $siswa), [
            'nis' => 'NIS-UPDATED',
            'nama' => $siswa->nama,
            'kelas' => $siswa->kelas,
        ])
        ->assertRedirect(route('admin.siswa.index'));

    assertDatabaseHas('siswas', ['id' => $siswa->id, 'nis' => 'NIS-UPDATED']);
});

it('admin dapat menghapus siswa', function () {
    $siswa = Siswa::factory()->create();

    actingAs($this->admin)
        ->delete(route('admin.siswa.destroy', $siswa))
        ->assertRedirect(route('admin.siswa.index'));

    assertDatabaseMissing('siswas', ['id' => $siswa->id]);
});

it('validasi NIS harus unik', function () {
    Siswa::factory()->create(['nis' => 'NIS-DUPLICATE']);

    actingAs($this->admin)
        ->post(route('admin.siswa.store'), [
            'nis' => 'NIS-DUPLICATE',
            'nama' => 'Another',
            'kelas' => 'X IPA 1',
        ])
        ->assertSessionHasErrors('nis');
});

// ============================================================
// PENGUJIAN FITUR ADMIN - CRUD NILAI
// ============================================================

it('admin dapat melihat daftar nilai', function () {
    actingAs($this->admin)
        ->get(route('admin.nilai.index'))
        ->assertSuccessful();
});

it('admin dapat menambah data nilai', function () {
    $siswa = Siswa::factory()->create();
    $guru = \App\Models\Guru::factory()->create();

    actingAs($this->admin)
        ->post(route('admin.nilai.store'), [
            'siswa_id' => $siswa->id,
            'guru_id' => $guru->id,
            'mata_pelajaran' => 'Matematika',
            'nilai_tugas' => 80,
            'nilai_uts' => 75,
            'nilai_uas' => 85,
        ])
        ->assertRedirect(route('admin.nilai.index'));

    assertDatabaseHas('nilais', [
        'siswa_id' => $siswa->id,
        'nilai_akhir' => 80.5,
        'status' => 'Lulus',
    ]);
});

it('validasi nilai harus dalam rentang 0-100', function (string $field, string $value) {
    Siswa::factory()->create();
    \App\Models\Guru::factory()->create();

    actingAs($this->admin)
        ->post(route('admin.nilai.store'), [
            'siswa_id' => 1,
            'guru_id' => 1,
            'mata_pelajaran' => 'Test',
            'nilai_tugas' => $field === 'nilai_tugas' ? $value : 50,
            'nilai_uts' => $field === 'nilai_uts' ? $value : 50,
            'nilai_uas' => $field === 'nilai_uas' ? $value : 50,
        ])
        ->assertSessionHasErrors($field);
})->with([
    'nilai_tugas -1' => ['nilai_tugas', '-1'],
    'nilai_uts 150' => ['nilai_uts', '150'],
    'nilai_uas 200' => ['nilai_uas', '200'],
]);

it('admin dapat mengedit nilai', function () {
    $siswa = Siswa::factory()->create();
    $guru = \App\Models\Guru::factory()->create();
    $nilai = \App\Models\Nilai::factory()->create([
        'siswa_id' => $siswa->id,
        'guru_id' => $guru->id,
    ]);

    actingAs($this->admin)
        ->put(route('admin.nilai.update', $nilai), [
            'siswa_id' => $siswa->id,
            'guru_id' => $guru->id,
            'mata_pelajaran' => 'Updated',
            'nilai_tugas' => 100,
            'nilai_uts' => 100,
            'nilai_uas' => 100,
        ])
        ->assertRedirect(route('admin.nilai.index'));

    assertDatabaseHas('nilais', ['id' => $nilai->id, 'nilai_akhir' => 100.0]);
});

it('admin dapat menghapus nilai', function () {
    $nilai = \App\Models\Nilai::factory()->create();

    actingAs($this->admin)
        ->delete(route('admin.nilai.destroy', $nilai))
        ->assertRedirect(route('admin.nilai.index'));

    assertDatabaseMissing('nilais', ['id' => $nilai->id]);
});
