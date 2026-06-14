@extends('layouts.app')
@section('title', 'Data Guru')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Data Guru</h2>
        <a href="{{ route('admin.guru.create') }}" class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">+ Tambah Guru</a>
    </div>
    <div class="rounded-lg bg-white shadow-sm border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode Guru</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mata Pelajaran</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($gurus as $guru)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $guru->kode_guru }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $guru->nama }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $guru->mata_pelajaran }}</td>
                    <td class="px-6 py-4 text-right text-sm space-x-2">
                        <a href="{{ route('admin.guru.edit', $guru) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                        <form action="{{ route('admin.guru.destroy', $guru) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data guru ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada data guru.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $gurus->links() }}</div>
</div>
@endsection
