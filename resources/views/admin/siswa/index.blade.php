@extends('layouts.app')
@section('title', 'Data Siswa')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Data Siswa</h2>
        <a href="{{ route('admin.siswa.create') }}" class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">+ Tambah Siswa</a>
    </div>

    <div class="rounded-lg bg-white shadow-sm border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIS</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kelas</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($siswas as $siswa)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $siswa->nis }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $siswa->nama }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $siswa->kelas }}</td>
                    <td class="px-6 py-4 text-right text-sm space-x-2">
                        <a href="{{ route('admin.siswa.edit', $siswa) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                        <form action="{{ route('admin.siswa.destroy', $siswa) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data siswa ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada data siswa.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $siswas->links() }}</div>
</div>
@endsection
