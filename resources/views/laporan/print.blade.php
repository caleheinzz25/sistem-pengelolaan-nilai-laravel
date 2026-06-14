<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Hasil Nilai Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { font-size: 12px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-white p-6">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-6">
            <h1 class="text-xl font-bold">LAPORAN HASIL NILAI SISWA</h1>
            <p class="text-sm text-gray-600">Sistem Pengelolaan Nilai</p>
            <p class="text-xs text-gray-500">Tanggal Cetak: {{ now()->format('d F Y') }}</p>
        </div>

        <div class="space-y-6">
            @foreach($laporanData as $laporan)
            <div class="border border-gray-300 rounded-lg p-4 page-break">
                <div class="grid grid-cols-4 gap-2 mb-3 text-sm">
                    <div><strong>NIS:</strong> {{ $laporan['nis'] }}</div>
                    <div><strong>Nama:</strong> {{ $laporan['nama'] }}</div>
                    <div><strong>Kelas:</strong> {{ $laporan['kelas'] }}</div>
                    <div>
                        <strong>Status:</strong>
                        <span class="{{ $laporan['status_kelulusan'] === 'Lulus' ? 'text-green-700' : 'text-red-700' }} font-semibold">
                            {{ $laporan['status_kelulusan'] }}
                        </span>
                    </div>
                </div>
                <table class="min-w-full border border-gray-300 text-xs">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-2 py-1 text-left">Mata Pelajaran</th>
                            <th class="border px-2 py-1 text-center">Tugas (30%)</th>
                            <th class="border px-2 py-1 text-center">UTS (30%)</th>
                            <th class="border px-2 py-1 text-center">UAS (40%)</th>
                            <th class="border px-2 py-1 text-center">Nilai Akhir</th>
                            <th class="border px-2 py-1 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laporan['nilai_per_mapel'] as $n)
                        <tr>
                            <td class="border px-2 py-1">{{ $n['mata_pelajaran'] }}</td>
                            <td class="border px-2 py-1 text-center">{{ $n['nilai_tugas'] }}</td>
                            <td class="border px-2 py-1 text-center">{{ $n['nilai_uts'] }}</td>
                            <td class="border px-2 py-1 text-center">{{ $n['nilai_uas'] }}</td>
                            <td class="border px-2 py-1 text-center font-semibold">{{ $n['nilai_akhir'] }}</td>
                            <td class="border px-2 py-1 text-center {{ $n['status'] === 'Lulus' ? 'text-green-700' : 'text-red-700' }}">{{ $n['status'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50 font-semibold">
                            <td class="border px-2 py-1">Rata-rata</td>
                            <td class="border px-2 py-1 text-center" colspan="4">{{ $laporan['rata_rata'] }}</td>
                            <td class="border px-2 py-1 text-center {{ $laporan['status_kelulusan'] === 'Lulus' ? 'text-green-700' : 'text-red-700' }}">{{ $laporan['status_kelulusan'] }}</td>
                        </tr>
                    </tfoot>
                </table>
                <p class="text-xs text-gray-500 mt-2">Rumus: Nilai Akhir = (30% × Tugas) + (30% × UTS) + (40% × UAS) | Kelulusan ≥ 70</p>
            </div>
            @endforeach
        </div>

        <div class="mt-6 text-center no-print">
            <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded text-sm">Cetak Laporan</button>
            <a href="{{ route('admin.laporan.index') }}" class="ml-2 text-sm text-blue-600">Kembali</a>
        </div>
    </div>
</body>
</html>
