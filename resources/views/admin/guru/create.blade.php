@extends('layouts.app')
@section('title', 'Tambah Guru')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-bold text-gray-900">Tambah Data Guru</h2>
    <form action="{{ route('admin.guru.store') }}" method="POST" class="space-y-6 max-w-lg">
        @csrf
        <div>
            <label for="kode_guru" class="block text-sm font-medium text-gray-900">Kode Guru</label>
            <input type="text" name="kode_guru" id="kode_guru" value="{{ old('kode_guru') }}" required
                class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm">
        </div>
        <div>
            <label for="nama" class="block text-sm font-medium text-gray-900">Nama Lengkap</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm">
        </div>
        <div>
            <label for="mata_pelajaran" class="block text-sm font-medium text-gray-900">Mata Pelajaran</label>
            <input type="text" name="mata_pelajaran" id="mata_pelajaran" value="{{ old('mata_pelajaran') }}" required
                class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm"
                placeholder="Contoh: Matematika">
        </div>
        <div class="flex gap-3">
            <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">Simpan</button>
            <a href="{{ route('admin.guru.index') }}" class="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Batal</a>
        </div>
    </form>
</div>
@endsection
