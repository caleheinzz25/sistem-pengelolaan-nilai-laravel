@extends('layouts.app')
@section('title', 'Edit Siswa')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-bold text-gray-900">Edit Data Siswa</h2>
    <form action="{{ route('admin.siswa.update', $siswa) }}" method="POST" class="space-y-6 max-w-lg">
        @csrf @method('PUT')
        <div>
            <label for="nis" class="block text-sm font-medium text-gray-900">NIS</label>
            <input type="text" name="nis" id="nis" value="{{ old('nis', $siswa->nis) }}" required
                class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm">
        </div>
        <div>
            <label for="nama" class="block text-sm font-medium text-gray-900">Nama Lengkap</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama', $siswa->nama) }}" required
                class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm">
        </div>
        <div>
            <label for="kelas" class="block text-sm font-medium text-gray-900">Kelas</label>
            <input type="text" name="kelas" id="kelas" value="{{ old('kelas', $siswa->kelas) }}" required
                class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm">
        </div>
        <div class="flex gap-3">
            <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">Update</button>
            <a href="{{ route('admin.siswa.index') }}" class="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Batal</a>
        </div>
    </form>
</div>
@endsection
