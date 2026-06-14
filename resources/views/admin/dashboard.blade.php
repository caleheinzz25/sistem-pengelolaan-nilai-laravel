@extends('layouts.app')
@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-bold text-gray-900">Dashboard Admin</h2>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="rounded-full bg-blue-100 p-3">
                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Siswa</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $totalSiswa }}</p>
                </div>
            </div>
        </div>
        <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="rounded-full bg-green-100 p-3">
                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 00-.491 6.347A48.62 48.62 0 0112 20.904a48.62 48.62 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.636 50.636 0 00-2.658-.813A59.906 59.906 0 0112 3.493a59.903 59.903 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Guru</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $totalGuru }}</p>
                </div>
            </div>
        </div>
        <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="rounded-full bg-yellow-100 p-3">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Nilai</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $totalNilai }}</p>
                </div>
            </div>
        </div>
        <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="rounded-full bg-purple-100 p-3">
                    <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Rata-rata Nilai</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $statistik['rata_rata'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Kelulusan -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik Kelulusan</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Total Siswa</span>
                    <span class="text-sm font-semibold">{{ $statistik['total_siswa'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-green-600">Lulus</span>
                    <span class="text-sm font-semibold text-green-600">{{ $statistik['lulus'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-red-600">Tidak Lulus</span>
                    <span class="text-sm font-semibold text-red-600">{{ $statistik['tidak_lulus'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Nilai Tertinggi</span>
                    <span class="text-sm font-semibold">{{ $statistik['nilai_tertinggi'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Nilai Terendah</span>
                    <span class="text-sm font-semibold">{{ $statistik['nilai_terendah'] }}</span>
                </div>
            </div>
        </div>

        <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Akses Cepat</h3>
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('admin.siswa.create') }}" class="flex items-center rounded-md bg-blue-50 p-4 hover:bg-blue-100">
                    <span class="text-blue-700 font-medium text-sm">+ Tambah Siswa</span>
                </a>
                <a href="{{ route('admin.guru.create') }}" class="flex items-center rounded-md bg-green-50 p-4 hover:bg-green-100">
                    <span class="text-green-700 font-medium text-sm">+ Tambah Guru</span>
                </a>
                <a href="{{ route('admin.nilai.create') }}" class="flex items-center rounded-md bg-yellow-50 p-4 hover:bg-yellow-100">
                    <span class="text-yellow-700 font-medium text-sm">+ Tambah Nilai</span>
                </a>
                <a href="{{ route('admin.laporan.index') }}" class="flex items-center rounded-md bg-purple-50 p-4 hover:bg-purple-100">
                    <span class="text-purple-700 font-medium text-sm">Lihat Laporan</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
