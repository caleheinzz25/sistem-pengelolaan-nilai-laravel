<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

// ============================================================
// PENGUJIAN FITUR LOGIN
// ============================================================

it('menampilkan halaman login', function () {
    $this->get('/login')->assertSuccessful();
});

it('root di-redirect ke halaman login untuk guest', function () {
    $this->get('/')->assertRedirect('/login');
});

it('user dapat login dengan kredensial valid', function () {
    $user = User::factory()->admin()->create(['email' => 'test@test.com']);

    post('/login', [
        'email' => 'test@test.com',
        'password' => 'password',
    ])
        ->assertRedirect('/admin/dashboard');

    $this->assertAuthenticated();
});

it('gagal login dengan kredensial salah', function () {
    User::factory()->create(['email' => 'test@test.com']);

    $response = $this->post('/login', [
        'email' => 'test@test.com',
        'password' => 'wrong-password',
    ]);

    $response->assertRedirect();

    $this->assertGuest();
});

it('admin diarahkan ke dashboard admin setelah login', function () {
    $user = User::factory()->admin()->create();

    actingAs($user)
        ->get('/admin/dashboard')
        ->assertSuccessful();
});

it('guru diarahkan ke dashboard guru setelah login', function () {
    $user = User::factory()->guru()->create();
    \App\Models\Guru::factory()->create(['user_id' => $user->id]);

    actingAs($user)
        ->get('/guru/dashboard')
        ->assertSuccessful();
});

it('siswa diarahkan ke dashboard siswa setelah login', function () {
    $user = User::factory()->siswa()->create();
    \App\Models\Siswa::factory()->create(['user_id' => $user->id]);

    actingAs($user)
        ->get('/siswa/dashboard')
        ->assertSuccessful();
});

it('siswa tidak dapat mengakses halaman admin', function () {
    $user = User::factory()->siswa()->create();

    actingAs($user)
        ->get('/admin/dashboard')
        ->assertForbidden();
});

it('guru tidak dapat mengakses halaman admin', function () {
    $user = User::factory()->guru()->create();

    actingAs($user)
        ->get('/admin/dashboard')
        ->assertForbidden();
});

it('admin tidak dapat mengakses halaman guru', function () {
    $user = User::factory()->admin()->create();

    actingAs($user)
        ->get('/guru/dashboard')
        ->assertForbidden();
});

it('user dapat logout', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->post('/logout')
        ->assertRedirect('/login');

    $this->assertGuest();
});

it('guest tidak dapat mengakses halaman dashboard tanpa login', function (string $url) {
    $this->get($url)->assertRedirect('/login');
})->with([
    'admin dashboard' => '/admin/dashboard',
    'guru dashboard' => '/guru/dashboard',
    'siswa dashboard' => '/siswa/dashboard',
]);
