@extends('layouts.app')
@section('title', 'Dashboard Guru')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-bold text-gray-900">Dashboard Guru</h2>
    <p class="text-gray-600">Selamat datang, <strong>{{ $guru->nama }}</strong> — Mata Pelajaran: <strong>{{ $guru->mata_pelajaran }}</strong></p>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
        <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
            <p class="text-sm text-gray-500">Siswa yang Diajar</p>
            <p class="text-3xl font-bold text-gray-900">{{ $jumlahSiswaDiajar }}</p>
        </div>
        <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
            <p class="text-sm text-gray-500">Total Nilai Tercatat</p>
            <p class="text-3xl font-bold text-gray-900">{{ $totalNilai }}</p>
        </div>
        <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
            <p class="text-sm text-gray-500">Rata-rata Nilai</p>
            <p class="text-3xl font-bold text-gray-900">{{ $statistik['rata_rata'] }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik Kelulusan — {{ $guru->mata_pelajaran }}</h3>
            <div class="space-y-3">
                <div class="flex justify-between"><span class="text-sm text-gray-600">Total</span><span class="text-sm font-semibold">{{ $statistik['total_siswa'] }}</span></div>
                <div class="flex justify-between"><span class="text-sm text-green-600">Lulus</span><span class="text-sm font-semibold text-green-600">{{ $statistik['lulus'] }}</span></div>
                <div class="flex justify-between"><span class="text-sm text-red-600">Tidak Lulus</span><span class="text-sm font-semibold text-red-600">{{ $statistik['tidak_lulus'] }}</span></div>
                <div class="flex justify-between"><span class="text-sm text-gray-600">Tertinggi</span><span class="text-sm font-semibold">{{ $statistik['nilai_tertinggi'] }}</span></div>
                <div class="flex justify-between"><span class="text-sm text-gray-600">Terendah</span><span class="text-sm font-semibold">{{ $statistik['nilai_terendah'] }}</span></div>
            </div>
        </div>
        <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Cepat</h3>
            <div class="space-y-3">
                <a href="{{ route('guru.input-nilai') }}" class="block rounded-md bg-blue-50 p-4 hover:bg-blue-100">
                    <span class="text-blue-700 font-medium text-sm">+ Input Nilai Siswa</span>
                </a>
                <a href="{{ route('guru.rekap') }}" class="block rounded-md bg-green-50 p-4 hover:bg-green-100">
                    <span class="text-green-700 font-medium text-sm">Lihat Rekap Nilai</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
