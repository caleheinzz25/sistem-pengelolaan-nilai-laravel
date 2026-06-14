<?php

namespace Database\Seeders;

use App\Helpers\NilaiHelper;
use App\Models\Guru;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // --- Admin ---
        User::factory()->create([
            'name' => 'Admin Sekolah',
            'email' => 'admin@sekolah.test',
            'role' => 'admin',
        ]);

        // --- Guru (3 orang) ---
        $guruData = [
            ['nama' => 'Budi Santoso, S.Pd.', 'kode_guru' => 'GRU-00001', 'mata_pelajaran' => 'Matematika'],
            ['nama' => 'Ani Rahmawati, S.Pd.', 'kode_guru' => 'GRU-00002', 'mata_pelajaran' => 'Bahasa Indonesia'],
            ['nama' => 'Dedi Kurniawan, M.Pd.', 'kode_guru' => 'GRU-00003', 'mata_pelajaran' => 'Bahasa Inggris'],
        ];

        $gurus = [];
        foreach ($guruData as $data) {
            $user = User::factory()->create([
                'name' => $data['nama'],
                'email' => str_replace([' ', ',', '.'], '', strtolower(explode(',', $data['nama'])[0])).'@sekolah.test',
                'role' => 'guru',
            ]);

            $gurus[] = Guru::factory()->create([
                'nama' => $data['nama'],
                'kode_guru' => $data['kode_guru'],
                'mata_pelajaran' => $data['mata_pelajaran'],
                'user_id' => $user->id,
            ]);
        }

        // --- Siswa (10 orang) ---
        $siswaNama = [
            'Andi Prasetyo', 'Bunga Citra Lestari', 'Candra Wijaya',
            'Dewi Sartika', 'Eko Nugroho', 'Fitri Handayani',
            'Gilang Ramadhan', 'Hana Permata', 'Irfan Hakim',
            'Jasmine Azzahra',
        ];

        $siswas = [];
        foreach ($siswaNama as $i => $nama) {
            $kelas = ['X IPA 1', 'X IPS 1', 'XI IPA 1', 'XI IPS 1', 'XII IPA 1', 'XII IPS 1'][$i % 6];

            $user = User::factory()->create([
                'name' => $nama,
                'email' => str_replace(' ', '', strtolower(explode(' ', $nama)[0])).'@siswa.test',
                'role' => 'siswa',
            ]);

            $siswas[] = Siswa::factory()->create([
                'nis' => 'NIS-'.str_pad((string) ($i + 1), 5, '0', STR_PAD_LEFT),
                'nama' => $nama,
                'kelas' => $kelas,
                'user_id' => $user->id,
            ]);
        }

        // --- Nilai untuk setiap siswa di 3 mata pelajaran ---
        // Because WithoutModelEvents is used, nilai_akhir dan status
        // dihitung secara eksplisit menggunakan NilaiHelper.
        foreach ($siswas as $index => $siswa) {
            $base = 50 + ($index * 5); // 50, 55, 60, ..., 95

            $tugas = min($base, 100);
            $uts = min($base + 5, 100);
            $uas = max(min($base - 5, 100), 40);
            $na = NilaiHelper::hitungNilaiAkhir($tugas, $uts, $uas);

            Nilai::create([
                'siswa_id' => $siswa->id,
                'guru_id' => $gurus[0]->id,
                'mata_pelajaran' => 'Matematika',
                'nilai_tugas' => $tugas,
                'nilai_uts' => $uts,
                'nilai_uas' => $uas,
                'nilai_akhir' => $na,
                'status' => NilaiHelper::tentukanStatusKelulusan($na),
            ]);

            $tugas2 = min(55 + ($index * 4), 100);
            $uts2 = min(58 + ($index * 4), 100);
            $uas2 = max(min(52 + ($index * 4), 100), 40);
            $na2 = NilaiHelper::hitungNilaiAkhir($tugas2, $uts2, $uas2);

            Nilai::create([
                'siswa_id' => $siswa->id,
                'guru_id' => $gurus[1]->id,
                'mata_pelajaran' => 'Bahasa Indonesia',
                'nilai_tugas' => $tugas2,
                'nilai_uts' => $uts2,
                'nilai_uas' => $uas2,
                'nilai_akhir' => $na2,
                'status' => NilaiHelper::tentukanStatusKelulusan($na2),
            ]);

            $tugas3 = min(60 + ($index * 3), 100);
            $uts3 = min(65 + ($index * 3), 100);
            $uas3 = max(min(60 + ($index * 3), 100), 40);
            $na3 = NilaiHelper::hitungNilaiAkhir($tugas3, $uts3, $uas3);

            Nilai::create([
                'siswa_id' => $siswa->id,
                'guru_id' => $gurus[2]->id,
                'mata_pelajaran' => 'Bahasa Inggris',
                'nilai_tugas' => $tugas3,
                'nilai_uts' => $uts3,
                'nilai_uas' => $uas3,
                'nilai_akhir' => $na3,
                'status' => NilaiHelper::tentukanStatusKelulusan($na3),
            ]);
        }
    }
}
