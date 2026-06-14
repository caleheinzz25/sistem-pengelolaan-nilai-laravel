@extends('layouts.app')
@section('title', 'Rekap Nilai')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Rekap Nilai — {{ $guru->mata_pelajaran }}</h2>
        <a href="{{ route('guru.input-nilai') }}" class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">+ Input Nilai</a>
    </div>
    <p class="text-sm text-gray-600">Guru: {{ $guru->nama }} ({{ $guru->kode_guru }})</p>
    <div class="rounded-lg bg-white shadow-sm border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIS</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Siswa</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kelas</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Tugas</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">UTS</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">UAS</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Akhir</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($rekap as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $item['nis'] }}</td>
                    <td class="px-4 py-3 text-sm text-gray-700">{{ $item['siswa'] }}</td>
                    <td class="px-4 py-3 text-sm text-gray-700">{{ $item['kelas'] }}</td>
                    <td class="px-4 py-3 text-sm text-center text-gray-700">{{ $item['nilai_tugas'] }}</td>
                    <td class="px-4 py-3 text-sm text-center text-gray-700">{{ $item['nilai_uts'] }}</td>
                    <td class="px-4 py-3 text-sm text-center text-gray-700">{{ $item['nilai_uas'] }}</td>
                    <td class="px-4 py-3 text-sm text-center font-semibold text-gray-900">{{ $item['nilai_akhir'] }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $item['status'] === 'Lulus' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $item['status'] }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-4 py-3 text-center text-sm text-gray-500">Belum ada data nilai.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
