<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sistem Pengelolaan Nilai')</title>
    @fonts
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full">
    <div class="flex h-full">
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col bg-slate-800">
            <!-- Logo -->
            <div class="flex h-16 items-center gap-2 border-b border-white/10 px-6">
                <svg class="h-7 w-7 text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 00-.491 6.347A48.62 48.62 0 0112 20.904a48.62 48.62 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.636 50.636 0 00-2.658-.813A59.906 59.906 0 0112 3.493a59.903 59.903 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0112 13.489a50.702 50.702 0 017.74-3.342" />
                </svg>
                <span class="text-sm font-semibold text-white leading-tight">Sistem<br>Pengelolaan Nilai</span>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto px-3 py-4">
                @auth
                    @if(auth()->user()->isAdmin())
                        <p class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Menu Admin</p>

                        <a href="{{ route('admin.dashboard') }}" class="group mb-1 flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-slate-900 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                            <svg class="h-5 w-5 shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-blue-400' : 'text-slate-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                            </svg>
                            Dashboard
                        </a>

                        <a href="{{ route('admin.siswa.index') }}" class="group mb-1 flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.siswa.*') ? 'bg-slate-900 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                            <svg class="h-5 w-5 shrink-0 {{ request()->routeIs('admin.siswa.*') ? 'text-blue-400' : 'text-slate-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                            Data Siswa
                        </a>

                        <a href="{{ route('admin.guru.index') }}" class="group mb-1 flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.guru.*') ? 'bg-slate-900 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                            <svg class="h-5 w-5 shrink-0 {{ request()->routeIs('admin.guru.*') ? 'text-blue-400' : 'text-slate-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 00-.491 6.347A48.62 48.62 0 0112 20.904a48.62 48.62 0 018.232-4.41 60.46 60.46 0 00-.491-6.347" />
                            </svg>
                            Data Guru
                        </a>

                        <a href="{{ route('admin.nilai.index') }}" class="group mb-1 flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.nilai.*') ? 'bg-slate-900 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                            <svg class="h-5 w-5 shrink-0 {{ request()->routeIs('admin.nilai.*') ? 'text-blue-400' : 'text-slate-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            Data Nilai
                        </a>

                        <a href="{{ route('admin.laporan.index') }}" class="group mb-1 flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.laporan.*') ? 'bg-slate-900 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                            <svg class="h-5 w-5 shrink-0 {{ request()->routeIs('admin.laporan.*') ? 'text-blue-400' : 'text-slate-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                            </svg>
                            Laporan
                        </a>
                    @endif

                    @if(auth()->user()->isGuru())
                        <p class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Menu Guru</p>

                        <a href="{{ route('guru.dashboard') }}" class="group mb-1 flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('guru.dashboard') ? 'bg-slate-900 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                            <svg class="h-5 w-5 shrink-0 {{ request()->routeIs('guru.dashboard') ? 'text-emerald-400' : 'text-slate-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                            </svg>
                            Dashboard
                        </a>

                        <a href="{{ route('guru.rekap') }}" class="group mb-1 flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('guru.rekap') ? 'bg-slate-900 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                            <svg class="h-5 w-5 shrink-0 {{ request()->routeIs('guru.rekap') ? 'text-emerald-400' : 'text-slate-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15a2.25 2.25 0 012.25 2.25v15.75a2.25 2.25 0 01-2.25 2.25H9a2.25 2.25 0 01-2.25-2.25V4.5A2.25 2.25 0 019 2.25h1.125c.69 0 1.25.56 1.25 1.25v.444z" />
                            </svg>
                            Rekap Nilai
                        </a>

                        <a href="{{ route('guru.input-nilai') }}" class="group mb-1 flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('guru.input-nilai') || request()->routeIs('guru.store-nilai') ? 'bg-slate-900 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                            <svg class="h-5 w-5 shrink-0 {{ request()->routeIs('guru.input-nilai') || request()->routeIs('guru.store-nilai') ? 'text-emerald-400' : 'text-slate-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Input Nilai
                        </a>
                    @endif

                    @if(auth()->user()->isSiswa())
                        <p class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Menu Siswa</p>

                        <a href="{{ route('siswa.dashboard') }}" class="group mb-1 flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('siswa.dashboard') ? 'bg-slate-900 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                            <svg class="h-5 w-5 shrink-0 {{ request()->routeIs('siswa.dashboard') ? 'text-purple-400' : 'text-slate-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                            </svg>
                            Nilai Saya
                        </a>
                    @endif
                @endauth
            </nav>

            <!-- User Info at Bottom -->
            <div class="border-t border-white/10 px-3 py-4">
                @auth
                    <div class="flex items-center gap-3 rounded-lg px-3 py-2">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full {{ auth()->user()->isAdmin() ? 'bg-blue-500/20 text-blue-300' : (auth()->user()->isGuru() ? 'bg-emerald-500/20 text-emerald-300' : 'bg-purple-500/20 text-purple-300') }} text-xs font-bold uppercase">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                            <p class="truncate text-xs capitalize text-slate-400">{{ auth()->user()->role }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="shrink-0">
                            @csrf
                            <button type="submit" title="Logout" class="flex h-8 w-8 items-center justify-center rounded-md text-slate-400 hover:bg-white/10 hover:text-white transition-colors">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                </svg>
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex flex-1 flex-col ml-64">
            <!-- Topbar -->
            <header class="sticky top-0 z-40 flex h-16 items-center gap-4 border-b border-gray-200 bg-white px-6 shadow-sm">
                <div class="flex flex-1 items-center gap-4">
                    @yield('header-actions')
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto">
                <div class="mx-auto max-w-7xl px-6 py-6">
                    @if(session('success'))
                        <div class="mb-4 rounded-md bg-green-50 p-4 border border-green-200">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 rounded-md bg-red-50 p-4 border border-red-200">
                            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                        </div>
                    @endif

                    @if(!empty($errors) && $errors->any())
                        <div class="mb-4 rounded-md bg-red-50 p-4 border border-red-200">
                            <ul class="list-disc list-inside text-sm text-red-800">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>
