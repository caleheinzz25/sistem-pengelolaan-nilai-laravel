@extends('layouts.app')
@section('title', 'Laporan Nilai')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Laporan Hasil Nilai Siswa</h2>
        <a href="{{ route('admin.laporan.print') }}" class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500" target="_blank">Cetak Laporan</a>
    </div>

    <!-- Filter -->
    <form method="GET" class="flex gap-4 items-end bg-white rounded-lg p-4 border border-gray-200">
        <div>
            <label for="kelas" class="block text-xs font-medium text-gray-700">Filter Kelas</label>
            <select name="kelas" id="kelas" class="mt-1 block rounded-md border-0 py-1.5 px-3 text-sm text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-blue-600">
                <option value="">Semua Kelas</option>
                @foreach($daftarKelas as $k)
                <option value="{{ $k }}" {{ $kelas == $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="status" class="block text-xs font-medium text-gray-700">Filter Status</label>
            <select name="status" id="status" class="mt-1 block rounded-md border-0 py-1.5 px-3 text-sm text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-blue-600">
                <option value="">Semua</option>
                <option value="Lulus" {{ $status === 'Lulus' ? 'selected' : '' }}>Lulus</option>
                <option value="Tidak Lulus" {{ $status === 'Tidak Lulus' ? 'selected' : '' }}>Tidak Lulus</option>
            </select>
        </div>
        <div>
            <button type="submit" class="rounded-md bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">Filter</button>
            <a href="{{ route('admin.laporan.index') }}" class="ml-2 text-sm text-gray-600 hover:text-gray-900">Reset</a>
        </div>
    </form>

    <!-- Statistik Global -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <div class="bg-white rounded-lg p-4 border border-gray-200 text-center">
            <p class="text-xs text-gray-500">Total</p>
            <p class="text-xl font-bold">{{ $statistikGlobal['total_siswa'] }}</p>
        </div>
        <div class="bg-white rounded-lg p-4 border border-gray-200 text-center">
            <p class="text-xs text-gray-500">Lulus</p>
            <p class="text-xl font-bold text-green-600">{{ $statistikGlobal['lulus'] }}</p>
        </div>
        <div class="bg-white rounded-lg p-4 border border-gray-200 text-center">
            <p class="text-xs text-gray-500">Tidak Lulus</p>
            <p class="text-xl font-bold text-red-600">{{ $statistikGlobal['tidak_lulus'] }}</p>
        </div>
        <div class="bg-white rounded-lg p-4 border border-gray-200 text-center">
            <p class="text-xs text-gray-500">Rata-rata</p>
            <p class="text-xl font-bold">{{ $statistikGlobal['rata_rata'] }}</p>
        </div>
        <div class="bg-white rounded-lg p-4 border border-gray-200 text-center">
            <p class="text-xs text-gray-500">Tertinggi</p>
            <p class="text-xl font-bold">{{ $statistikGlobal['nilai_tertinggi'] }}</p>
        </div>
    </div>

    <!-- Tabel Laporan -->
    <div class="rounded-lg bg-white shadow-sm border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIS</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kelas</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Rata-rata</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Detail</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($laporanData as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $item['nis'] }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $item['nama'] }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $item['kelas'] }}</td>
                    <td class="px-6 py-4 text-sm text-center font-semibold text-gray-900">{{ $item['rata_rata'] }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $item['status'] === 'Lulus' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $item['status'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.laporan.show', \App\Models\Siswa::where('nis', $item['nis'])->first()) }}" class="text-blue-600 hover:text-blue-900 text-sm">Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
