<?php

namespace Database\Seeders;

use App\Helpers\NilaiHelper;
use App\Models\Guru;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $password = Hash::make('password');
        $now = now();

        // ============================================================
        // ADMIN
        // ============================================================
        User::insert([
            'name' => 'Admin Sekolah',
            'email' => 'admin@sekolah.test',
            'role' => 'admin',
            'email_verified_at' => $now,
            'password' => $password,
            'remember_token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // ============================================================
        // GURU (6 orang)
        // ============================================================
        $guruData = [
            ['nama' => 'Budi Santoso, S.Pd.', 'kode_guru' => 'GRU-00001', 'mata_pelajaran' => 'Matematika', 'email' => 'budisantoso@sekolah.test'],
            ['nama' => 'Ani Rahmawati, S.Pd.', 'kode_guru' => 'GRU-00002', 'mata_pelajaran' => 'Bahasa Indonesia', 'email' => 'anirahmawati@sekolah.test'],
            ['nama' => 'Dedi Kurniawan, M.Pd.', 'kode_guru' => 'GRU-00003', 'mata_pelajaran' => 'Bahasa Inggris', 'email' => 'dedikurniawan@sekolah.test'],
            ['nama' => 'Siti Aminah, S.Pd.', 'kode_guru' => 'GRU-00004', 'mata_pelajaran' => 'Fisika', 'email' => 'sitiaminah@sekolah.test'],
            ['nama' => 'Ahmad Fauzi, M.Pd.', 'kode_guru' => 'GRU-00005', 'mata_pelajaran' => 'Kimia', 'email' => 'ahmadfauzi@sekolah.test'],
            ['nama' => 'Rina Wulandari, S.Pd.', 'kode_guru' => 'GRU-00006', 'mata_pelajaran' => 'Biologi', 'email' => 'rinawulandari@sekolah.test'],
        ];

        $guruIds = [];
        foreach ($guruData as $data) {
            $userId = User::insertGetId([
                'name' => $data['nama'],
                'email' => $data['email'],
                'role' => 'guru',
                'email_verified_at' => $now,
                'password' => $password,
                'remember_token' => Str::random(10),
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $guruIds[] = Guru::insertGetId([
                'user_id' => $userId,
                'nama' => $data['nama'],
                'kode_guru' => $data['kode_guru'],
                'mata_pelajaran' => $data['mata_pelajaran'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // ============================================================
        // SISWA (300 orang)
        // ============================================================
        $jumlahSiswa = 300;
        $kelasList = ['X IPA 1', 'X IPA 2', 'X IPS 1', 'X IPS 2', 'XI IPA 1', 'XI IPA 2', 'XI IPS 1', 'XI IPS 2', 'XII IPA 1', 'XII IPA 2', 'XII IPS 1', 'XII IPS 2'];

        // User untuk siswa pertama (Andi Prasetyo) — akun demo
        $siswaUsers = [
            [
                'name' => 'Andi Prasetyo',
                'email' => 'andi@siswa.test',
                'role' => 'siswa',
                'email_verified_at' => $now,
                'password' => $password,
                'remember_token' => Str::random(10),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Generate 299 user siswa lainnya
        for ($i = 2; $i <= $jumlahSiswa; $i++) {
            $siswaUsers[] = [
                'name' => fake()->name(),
                'email' => 'siswa'.str_pad((string) $i, 3, '0', STR_PAD_LEFT).'@siswa.test',
                'role' => 'siswa',
                'email_verified_at' => $now,
                'password' => $password,
                'remember_token' => Str::random(10),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        User::insert($siswaUsers);

        // Ambil ID user siswa yang baru dibuat
        $siswaUserIds = User::where('role', 'siswa')
            ->orderBy('id')
            ->pluck('id')
            ->toArray();

        // Generate record siswa
        $siswaRecords = [];
        $namaDepan = ['Andi', 'Bunga', 'Candra', 'Dewi', 'Eko', 'Fitri', 'Gilang', 'Hana', 'Irfan', 'Jasmine'];
        foreach ($siswaUserIds as $index => $userId) {
            $i = $index + 1;

            if ($i === 1) {
                $nama = 'Andi Prasetyo';
            } elseif ($i <= 10) {
                $nama = $namaDepan[$index].' '.fake()->lastName();
            } else {
                $nama = fake()->name();
            }

            $siswaRecords[] = [
                'user_id' => $userId,
                'nis' => 'NIS-'.str_pad((string) $i, 5, '0', STR_PAD_LEFT),
                'nama' => $nama,
                'kelas' => $kelasList[$index % count($kelasList)],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        Siswa::insert($siswaRecords);

        // Ambil ID siswa yang baru dibuat
        $siswaIds = Siswa::orderBy('id')
            ->pluck('id')
            ->toArray();

        // ============================================================
        // NILAI — setiap siswa mendapat nilai dari 6 guru
        // Total: 300 × 6 = 1.800 record
        // Karena WithoutModelEvents aktif, hitung nilai_akhir & status
        // secara eksplisit menggunakan NilaiHelper.
        // ============================================================
        $nilaiRecords = [];
        $mataPelajaranPerGuru = array_column($guruData, 'mata_pelajaran');

        foreach ($siswaIds as $siswaIndex => $siswaId) {
            foreach ($guruIds as $guruIndex => $guruId) {
                // Variasi nilai berdasarkan indeks siswa dan guru agar data realistis
                $base = 50 + (($siswaIndex + $guruIndex * 3) % 45);

                $tugas = min($base + 5, 100);
                $uts = min($base + 10, 100);
                $uas = max(min($base, 100), 40);

                $na = NilaiHelper::hitungNilaiAkhir($tugas, $uts, $uas);

                $nilaiRecords[] = [
                    'siswa_id' => $siswaId,
                    'guru_id' => $guruId,
                    'mata_pelajaran' => $mataPelajaranPerGuru[$guruIndex],
                    'nilai_tugas' => $tugas,
                    'nilai_uts' => $uts,
                    'nilai_uas' => $uas,
                    'nilai_akhir' => $na,
                    'status' => NilaiHelper::tentukanStatusKelulusan($na),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // Insert nilai dalam batch untuk performa
        foreach (array_chunk($nilaiRecords, 500) as $chunk) {
            Nilai::insert($chunk);
        }
    }
}
