@extends('layouts.app')
@section('title', 'Nilai Saya')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-bold text-gray-900">Nilai Saya</h2>
    <p class="text-gray-600">Selamat datang, <strong>{{ $siswa->nama }}</strong> | NIS: {{ $siswa->nis }} | Kelas: {{ $siswa->kelas }}</p>

    <!-- Status Kelulusan -->
    <div class="rounded-lg p-6 {{ $laporan['status_kelulusan'] === 'Lulus' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
        <h3 class="text-lg font-semibold {{ $laporan['status_kelulusan'] === 'Lulus' ? 'text-green-900' : 'text-red-900' }}">
            Status Kelulusan: <span class="font-bold">{{ $laporan['status_kelulusan'] }}</span>
        </h3>
        <p class="text-sm {{ $laporan['status_kelulusan'] === 'Lulus' ? 'text-green-700' : 'text-red-700' }}">
            Rata-rata Nilai Akhir: <strong>{{ $laporan['rata_rata'] }}</strong> (Ambang batas: 70)
        </p>
    </div>

    <!-- Rincian Nilai per Mata Pelajaran -->
    <div class="rounded-lg bg-white shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Rincian Nilai per Mata Pelajaran</h3>
        </div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mata Pelajaran</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Tugas (30%)</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">UTS (30%)</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">UAS (40%)</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Nilai Akhir</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($laporan['nilai_per_mapel'] as $nilai)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $nilai['mata_pelajaran'] }}</td>
                    <td class="px-6 py-4 text-sm text-center text-gray-700">{{ $nilai['nilai_tugas'] }}</td>
                    <td class="px-6 py-4 text-sm text-center text-gray-700">{{ $nilai['nilai_uts'] }}</td>
                    <td class="px-6 py-4 text-sm text-center text-gray-700">{{ $nilai['nilai_uas'] }}</td>
                    <td class="px-6 py-4 text-sm text-center font-semibold text-gray-900">{{ $nilai['nilai_akhir'] }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $nilai['status'] === 'Lulus' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $nilai['status'] }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada data nilai.</td></tr>
                @endforelse
            </tbody>
            <tfoot class="bg-gray-50">
                <tr>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-900" colspan="4">Rata-rata</td>
                    <td class="px-6 py-4 text-sm text-center font-bold text-gray-900">{{ $laporan['rata_rata'] }}</td>
                    <td class="px-6 py-4 text-center font-bold {{ $laporan['status_kelulusan'] === 'Lulus' ? 'text-green-700' : 'text-red-700' }}">
                        {{ $laporan['status_kelulusan'] }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="rounded-md bg-gray-50 p-4 border border-gray-200">
        <p class="text-xs text-gray-500">
            <strong>Rumus:</strong> Nilai Akhir = (30% × Tugas) + (30% × UTS) + (40% × UAS) | Kelulusan: ≥ 70
        </p>
    </div>
</div>
@endsection
