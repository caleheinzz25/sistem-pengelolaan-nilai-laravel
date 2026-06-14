@extends('layouts.app')
@section('title', 'Detail Laporan')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Detail Laporan Siswa</h2>
        <a href="{{ route('admin.laporan.index') }}" class="text-sm text-blue-600 hover:text-blue-900">← Kembali ke Laporan</a>
    </div>

    <div class="rounded-lg bg-white shadow-sm border border-gray-200 p-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div><p class="text-xs text-gray-500">NIS</p><p class="text-sm font-semibold">{{ $laporan['nis'] }}</p></div>
            <div><p class="text-xs text-gray-500">Nama</p><p class="text-sm font-semibold">{{ $laporan['nama'] }}</p></div>
            <div><p class="text-xs text-gray-500">Kelas</p><p class="text-sm font-semibold">{{ $laporan['kelas'] }}</p></div>
            <div>
                <p class="text-xs text-gray-500">Status</p>
                <span class="inline-flex rounded-full px-2 text-xs font-semibold {{ $laporan['status_kelulusan'] === 'Lulus' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $laporan['status_kelulusan'] }} ({{ $laporan['rata_rata'] }})
                </span>
            </div>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mata Pelajaran</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Tugas</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">UTS</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">UAS</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Nilai Akhir</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @foreach($laporan['nilai_per_mapel'] as $n)
                <tr>
                    <td class="px-4 py-3 text-sm font-medium">{{ $n['mata_pelajaran'] }}</td>
                    <td class="px-4 py-3 text-sm text-center">{{ $n['nilai_tugas'] }}</td>
                    <td class="px-4 py-3 text-sm text-center">{{ $n['nilai_uts'] }}</td>
                    <td class="px-4 py-3 text-sm text-center">{{ $n['nilai_uas'] }}</td>
                    <td class="px-4 py-3 text-sm text-center font-semibold">{{ $n['nilai_akhir'] }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="inline-flex rounded-full px-2 text-xs font-semibold {{ $n['status'] === 'Lulus' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $n['status'] }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
