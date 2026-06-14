@extends('layouts.app')
@section('title', 'Data Nilai')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Data Nilai</h2>
        <a href="{{ route('admin.nilai.create') }}" class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">+ Tambah Nilai</a>
    </div>
    <div class="rounded-lg bg-white shadow-sm border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Siswa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mata Pelajaran</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Tugas</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">UTS</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">UAS</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Akhir</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($nilais as $nilai)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $nilai->siswa?->nama ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $nilai->mata_pelajaran }}</td>
                    <td class="px-6 py-4 text-sm text-center text-gray-700">{{ $nilai->nilai_tugas }}</td>
                    <td class="px-6 py-4 text-sm text-center text-gray-700">{{ $nilai->nilai_uts }}</td>
                    <td class="px-6 py-4 text-sm text-center text-gray-700">{{ $nilai->nilai_uas }}</td>
                    <td class="px-6 py-4 text-sm text-center font-semibold text-gray-900">{{ $nilai->nilai_akhir }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $nilai->status === 'Lulus' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $nilai->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right text-sm space-x-2">
                        <a href="{{ route('admin.nilai.edit', $nilai) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                        <form action="{{ route('admin.nilai.destroy', $nilai) }}" method="POST" class="inline" onsubmit="return confirm('Hapus nilai ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada data nilai.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $nilais->links() }}</div>
</div>
@endsection
