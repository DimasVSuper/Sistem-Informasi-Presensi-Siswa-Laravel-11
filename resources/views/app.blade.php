<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#4f46e5"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">

    <title>@yield('title', 'Aplikasi Presensi Siswa')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Scripts & Icons -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden text-gray-800 antialiased selection:bg-indigo-100 selection:text-indigo-900">

    @auth
        @unless(request()->is('scan') || request()->is('generate') || request()->is('login'))
        <!-- AUTH LOGGED-IN: Sidebar -->
        <aside class="w-64 bg-indigo-900 text-white flex flex-col transition-all duration-300 shadow-xl z-20">
            <div class="h-16 flex items-center px-6 border-b border-indigo-800 font-bold text-lg tracking-wider">
                <i data-feather="monitor" class="w-5 h-5 mr-3 text-indigo-400"></i> Admin Panel
            </div>
            <nav class="flex-1 py-6 space-y-1.5 px-3 overflow-y-auto">
                <p class="px-3 text-xs font-semibold text-indigo-400 uppercase tracking-wider mb-2 mt-4">Menu Utama</p>
                <a href="{{ route('dashboard.index') }}" class="flex items-center px-3 py-2.5 rounded-xl hover:bg-indigo-800 transition-colors {{ request()->routeIs('dashboard.*') ? 'bg-indigo-800 shadow-inner' : 'text-indigo-100' }}">
                    <i data-feather="grid" class="w-4 h-4 mr-3 {{ request()->routeIs('dashboard.*') ? 'text-indigo-300' : 'opacity-75' }}"></i> Dashboard
                </a>
                
                <p class="px-3 text-xs font-semibold text-indigo-400 uppercase tracking-wider mb-2 mt-8">Master Data</p>
                <a href="{{ route('siswa.index') }}" class="flex items-center px-3 py-2.5 rounded-xl hover:bg-indigo-800 transition-colors {{ request()->routeIs('siswa.*') ? 'bg-indigo-800 shadow-inner' : 'text-indigo-100' }}">
                    <i data-feather="users" class="w-4 h-4 mr-3 {{ request()->routeIs('siswa.*') ? 'text-indigo-300' : 'opacity-75' }}"></i> Data Siswa
                </a>
                <a href="{{ route('orang-tua.index') }}" class="flex items-center px-3 py-2.5 rounded-xl hover:bg-indigo-800 transition-colors {{ request()->routeIs('orang-tua.*') ? 'bg-indigo-800 shadow-inner' : 'text-indigo-100' }}">
                    <i data-feather="user" class="w-4 h-4 mr-3 {{ request()->routeIs('orang-tua.*') ? 'text-indigo-300' : 'opacity-75' }}"></i> Data Orang Tua
                </a>
            </nav>
            <div class="p-4 border-t border-indigo-800 bg-indigo-950/30">
                <div class="flex items-center mb-4">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center text-sm font-bold shadow-sm">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="ml-3 overflow-hidden">
                        <p class="text-sm font-medium leading-none text-white truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-indigo-300 mt-1 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2 border border-indigo-700/50 rounded-xl shadow-sm text-sm font-medium text-white hover:bg-indigo-800 transition-colors">
                        <i data-feather="log-out" class="w-4 h-4 mr-2"></i> Log Out
                    </button>
                </form>
            </div>
        </aside>
        @endunless
    @endauth

    <!-- Main Content Wrapper -->
    <main class="flex-1 flex flex-col overflow-hidden relative">
        
        <!-- Navbar -->
        <header class="h-16 bg-white/80 backdrop-blur-md shadow-sm border-b border-gray-100 flex items-center justify-between px-6 lg:px-10 z-10 sticky top-0">
            <div class="flex items-center gap-3">
                @if(request()->is('scan') || request()->is('generate') || request()->is('login'))
                    <!-- Logo for non-admin modules -->
                    <div class="w-8 h-8 bg-indigo-600 rounded flex items-center justify-center shadow-sm">
                        <i data-feather="check-square" class="w-4 h-4 text-white"></i>
                    </div>
                    <h1 class="text-lg font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600 tracking-tight">PresensiGo</h1>
                @else
                    <h1 class="text-xl font-semibold text-gray-800 tracking-tight">
                        @yield('header_title', 'Sistem Presensi')
                    </h1>
                @endif
            </div>

            <div class="flex items-center space-x-3">
                @if(!request()->is('scan'))
                <a href="{{ route('scan') }}" target="_blank" class="text-xs lg:text-sm font-medium text-indigo-600 hover:text-white hover:bg-indigo-600 border border-indigo-200 px-3 py-1.5 rounded-lg transition-all shadow-sm flex items-center">
                    <i data-feather="camera" class="w-3.5 h-3.5 mr-1.5"></i> QR Scanner
                </a>
                @endif
                @if(!Auth::check() && !request()->is('login'))
                <a href="{{ route('login') }}" class="text-xs lg:text-sm text-gray-600 hover:text-gray-900 font-medium bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-lg transition-all">
                    Admin Login
                </a>
                @endif
            </div>
        </header>

        <!-- Page Content -->
        <div class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50/50 p-4 lg:p-8">
            
            <div class="max-w-7xl mx-auto">
                @if(session('success'))
                <div class="bg-indigo-50/50 backdrop-blur border-l-4 border-indigo-500 p-4 rounded-r-xl mb-6 shadow-sm flex items-start animate-fade-in-down">
                    <i data-feather="check-circle" class="w-5 h-5 text-indigo-500 mr-3 mt-0.5"></i>
                    <div>
                        <h3 class="font-semibold text-indigo-800">Berhasil</h3>
                        <p class="text-sm text-indigo-600 mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="bg-red-50/50 backdrop-blur border-l-4 border-red-500 p-4 rounded-r-xl mb-6 shadow-sm flex items-start animate-fade-in-down">
                    <i data-feather="alert-circle" class="w-5 h-5 text-red-500 mr-3 mt-0.5"></i>
                    <div>
                        <h3 class="font-semibold text-red-800">Terjadi Kesalahan</h3>
                        <p class="text-sm text-red-600 mt-0.5">{{ session('error') }}</p>
                    </div>
                </div>
                @endif

                @yield('content')
            </div>

        </div>
    </main>

    <script>
        feather.replace();
    </script>
    <script src="{{ asset('/sw.js') }}"></script>
    <script>
        if (!navigator.serviceWorker.controller) {
            navigator.serviceWorker.register("/sw.js").then(function (reg) {
                console.log("Service worker has been registered for scope: " + reg.scope);
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
