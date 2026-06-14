@extends('layouts.app')
@section('title', 'Tambah Nilai')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-bold text-gray-900">Tambah Data Nilai</h2>
    <form action="{{ route('admin.nilai.store') }}" method="POST" class="space-y-6 max-w-lg">
        @csrf
        <div>
            <label for="siswa_id" class="block text-sm font-medium text-gray-900">Siswa</label>
            <select name="siswa_id" id="siswa_id" required
                class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm">
                <option value="">Pilih Siswa</option>
                @foreach($siswas as $s)
                <option value="{{ $s->id }}" {{ old('siswa_id') == $s->id ? 'selected' : '' }}>{{ $s->nis }} - {{ $s->nama }} ({{ $s->kelas }})</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="guru_id" class="block text-sm font-medium text-gray-900">Guru</label>
            <select name="guru_id" id="guru_id" required
                class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm">
                <option value="">Pilih Guru</option>
                @foreach($gurus as $g)
                <option value="{{ $g->id }}" {{ old('guru_id') == $g->id ? 'selected' : '' }}>{{ $g->nama }} - {{ $g->mata_pelajaran }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="mata_pelajaran" class="block text-sm font-medium text-gray-900">Mata Pelajaran</label>
            <input type="text" name="mata_pelajaran" id="mata_pelajaran" value="{{ old('mata_pelajaran') }}" required
                class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm">
        </div>
        <div class="grid grid-cols-3 gap-4">
            <div>
                <label for="nilai_tugas" class="block text-sm font-medium text-gray-900">Nilai Tugas</label>
                <input type="number" name="nilai_tugas" id="nilai_tugas" value="{{ old('nilai_tugas') }}" min="0" max="100" step="0.01" required
                    class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm">
            </div>
            <div>
                <label for="nilai_uts" class="block text-sm font-medium text-gray-900">Nilai UTS</label>
                <input type="number" name="nilai_uts" id="nilai_uts" value="{{ old('nilai_uts') }}" min="0" max="100" step="0.01" required
                    class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm">
            </div>
            <div>
                <label for="nilai_uas" class="block text-sm font-medium text-gray-900">Nilai UAS</label>
                <input type="number" name="nilai_uas" id="nilai_uas" value="{{ old('nilai_uas') }}" min="0" max="100" step="0.01" required
                    class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm">
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">Simpan</button>
            <a href="{{ route('admin.nilai.index') }}" class="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Batal</a>
        </div>
    </form>
</div>
@endsection
