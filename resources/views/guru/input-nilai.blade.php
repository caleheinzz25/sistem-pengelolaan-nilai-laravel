@extends('layouts.app')
@section('title', 'Input Nilai')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-bold text-gray-900">Input Nilai Siswa</h2>
    <p class="text-sm text-gray-600">Guru: <strong>{{ $guru->nama }}</strong> | Mata Pelajaran: <strong>{{ $guru->mata_pelajaran }}</strong></p>

    <form action="{{ route('guru.store-nilai') }}" method="POST" class="space-y-6 max-w-lg">
        @csrf
        <div>
            <label for="siswa_id" class="block text-sm font-medium text-gray-900">Pilih Siswa</label>
            <select name="siswa_id" id="siswa_id" required
                class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm">
                <option value="">Pilih Siswa</option>
                @foreach($siswas as $s)
                <option value="{{ $s->id }}" {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                    {{ $s->nis }} - {{ $s->nama }} ({{ $s->kelas }})
                    {{ in_array($s->id, $siswaSudahDinilai) ? '✓ Sudah dinilai' : '' }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label for="nilai_tugas" class="block text-sm font-medium text-gray-900">Nilai Tugas (30%)</label>
                <input type="number" name="nilai_tugas" id="nilai_tugas" value="{{ old('nilai_tugas') }}" min="0" max="100" step="0.01" required
                    class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm">
            </div>
            <div>
                <label for="nilai_uts" class="block text-sm font-medium text-gray-900">Nilai UTS (30%)</label>
                <input type="number" name="nilai_uts" id="nilai_uts" value="{{ old('nilai_uts') }}" min="0" max="100" step="0.01" required
                    class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm">
            </div>
            <div>
                <label for="nilai_uas" class="block text-sm font-medium text-gray-900">Nilai UAS (40%)</label>
                <input type="number" name="nilai_uas" id="nilai_uas" value="{{ old('nilai_uas') }}" min="0" max="100" step="0.01" required
                    class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm">
            </div>
        </div>

        <div class="rounded-md bg-blue-50 p-4 border border-blue-200">
            <h4 class="text-sm font-medium text-blue-800">Informasi Perhitungan</h4>
            <p class="mt-1 text-xs text-blue-700">Nilai Akhir = (30% × Tugas) + (30% × UTS) + (40% × UAS)</p>
            <p class="text-xs text-blue-700">Siswa lulus jika nilai akhir ≥ 70</p>
            <p class="text-xs text-blue-700">Rentang nilai valid: 0–100</p>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">Simpan Nilai</button>
            <a href="{{ route('guru.rekap') }}" class="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">Lihat Rekap</a>
        </div>
    </form>
</div>
@endsection
