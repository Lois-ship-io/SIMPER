<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIMPER') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Tailwind CDN (Fallback for uncompiled classes) -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <style>
            body { font-family: 'Inter', sans-serif; }
            /* Custom Scrollbar for sidebar */
            .sidebar-scroll::-webkit-scrollbar {
                width: 4px;
            }
            .sidebar-scroll::-webkit-scrollbar-track {
                background: transparent;
            }
            .sidebar-scroll::-webkit-scrollbar-thumb {
                background: #e5e7eb;
                border-radius: 4px;
            }
            .sidebar-scroll:hover::-webkit-scrollbar-thumb {
                background: #d1d5db;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-800 overflow-hidden">
        <div class="h-screen flex" x-data="{ sidebarOpen: true, mobileMenuOpen: false }">
            
            <!-- Mobile Sidebar Backdrop -->
            <div x-show="mobileMenuOpen" class="fixed inset-0 z-20 bg-gray-900 bg-opacity-50 transition-opacity lg:hidden" @click="mobileMenuOpen = false"></div>

            <!-- Sidebar -->
            <aside :class="sidebarOpen ? 'w-64' : 'w-20'" class="fixed inset-y-0 left-0 z-30 bg-white border-r border-gray-200 transition-all duration-300 flex flex-col transform lg:translate-x-0 lg:static lg:inset-0" x-bind:class="mobileMenuOpen ? 'translate-x-0' : '-translate-x-full'">
                <div class="h-16 flex items-center justify-center border-b border-gray-200 px-4 flex-shrink-0 relative overflow-hidden">
                    <h2 x-show="sidebarOpen || mobileMenuOpen" class="font-bold text-2xl text-emerald-600 tracking-tight transition-opacity duration-300">SIMPER</h2>
                    <h2 x-show="!sidebarOpen && !mobileMenuOpen" class="font-bold text-2xl text-emerald-600 transition-opacity duration-300 absolute">S</h2>
                </div>
                
                <div class="flex-1 overflow-y-auto py-4 sidebar-scroll">
                    <nav class="space-y-1 px-3">
                        <!-- Dashboard -->
                        <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2.5 {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-700 border border-emerald-100 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 border border-transparent' }} rounded-xl group font-medium transition-all duration-200">
                            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('dashboard') ? 'text-emerald-600' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            <span x-show="sidebarOpen || mobileMenuOpen" class="ml-3 truncate">Dashboard</span>
                        </a>

                        @can('books.view')
                        <a href="{{ route('books.index') }}" class="flex items-center px-3 py-2.5 {{ request()->routeIs('books.*') ? 'bg-emerald-50 text-emerald-700 border border-emerald-100 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 border border-transparent' }} rounded-xl group font-medium transition-all duration-200">
                            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('books.*') ? 'text-emerald-600' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            <span x-show="sidebarOpen || mobileMenuOpen" class="ml-3 truncate">Data Buku</span>
                        </a>
                        @endcan

                        @can('visitors.view')
                        <a href="{{ route('visitors.index') }}" class="flex items-center px-3 py-2.5 {{ request()->routeIs('visitors.*') ? 'bg-emerald-50 text-emerald-700 border border-emerald-100 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 border border-transparent' }} rounded-xl group font-medium transition-all duration-200">
                            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('visitors.*') ? 'text-emerald-600' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <span x-show="sidebarOpen || mobileMenuOpen" class="ml-3 truncate">Data Pengunjung</span>
                        </a>
                        @endcan

                        @can('members.view')
                        <a href="{{ route('members.index') }}" class="flex items-center px-3 py-2.5 {{ request()->routeIs('members.*') ? 'bg-emerald-50 text-emerald-700 border border-emerald-100 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 border border-transparent' }} rounded-xl group font-medium transition-all duration-200">
                            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('members.*') ? 'text-emerald-600' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <span x-show="sidebarOpen || mobileMenuOpen" class="ml-3 truncate">Data Anggota</span>
                        </a>
                        @endcan

                        @can('borrowings.view')
                        <!-- Sirkulasi -->
                        <a href="{{ route('borrowings.index') }}" class="flex items-center px-3 py-2.5 {{ request()->routeIs('borrowings.*') ? 'bg-emerald-50 text-emerald-700 border border-emerald-100 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 border border-transparent' }} rounded-xl group font-medium transition-all duration-200">
                            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('borrowings.*') ? 'text-emerald-600' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span x-show="sidebarOpen || mobileMenuOpen" class="ml-3 truncate">Data Peminjaman Buku</span>
                        </a>
                        @endcan

                        @can('returns.view')
                        <a href="{{ route('returns.index') }}" class="flex items-center px-3 py-2.5 {{ request()->routeIs('returns.*') ? 'bg-emerald-50 text-emerald-700 border border-emerald-100 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 border border-transparent' }} rounded-xl group font-medium transition-all duration-200">
                            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('returns.*') ? 'text-emerald-600' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span x-show="sidebarOpen || mobileMenuOpen" class="ml-3 truncate">Data Pengembalian Buku</span>
                        </a>
                        @endcan

                        @can('reports.view')
                        <!-- Laporan -->
                        <a href="{{ route('reports.borrowings') }}" class="flex items-center px-3 py-2.5 {{ request()->routeIs('reports.borrowings') ? 'bg-emerald-50 text-emerald-700 border border-emerald-100 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 border border-transparent' }} rounded-xl group font-medium transition-all duration-200">
                            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('reports.borrowings') ? 'text-emerald-600' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span x-show="sidebarOpen || mobileMenuOpen" class="ml-3 truncate">Laporan Data Peminjaman</span>
                        </a>
                        <a href="{{ route('reports.returns') }}" class="flex items-center px-3 py-2.5 {{ request()->routeIs('reports.returns') ? 'bg-emerald-50 text-emerald-700 border border-emerald-100 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 border border-transparent' }} rounded-xl group font-medium transition-all duration-200">
                            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('reports.returns') ? 'text-emerald-600' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span x-show="sidebarOpen || mobileMenuOpen" class="ml-3 truncate">Laporan Data Pengembalian</span>
                        </a>
                        @endcan

                        @can('users.view')
                        <a href="{{ route('users.index') }}" class="flex items-center px-3 py-2.5 {{ request()->routeIs('users.*') ? 'bg-emerald-50 text-emerald-700 border border-emerald-100 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 border border-transparent' }} rounded-xl group font-medium transition-all duration-200">
                            <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('users.*') ? 'text-emerald-600' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <span x-show="sidebarOpen || mobileMenuOpen" class="ml-3 truncate">Data Pengguna</span>
                        </a>
                        @endcan

                        <div class="pt-4 mt-4 border-t border-gray-100">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-3 py-2.5 text-red-600 hover:bg-red-50 rounded-xl group font-medium transition-all duration-200">
                                    <svg class="w-5 h-5 flex-shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    <span x-show="sidebarOpen || mobileMenuOpen" class="ml-3 truncate">Logout</span>
                                </button>
                            </form>
                        </div>
                    </nav>
                </div>
            </aside>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
                <!-- Top Navbar -->
                <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 sm:px-6 lg:px-8 shadow-sm flex-shrink-0">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-emerald-600 focus:outline-none hidden lg:block mr-4 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path x-show="sidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                <path x-show="!sidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                            </svg>
                        </button>
                        
                        <!-- Responsive menu button -->
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-500 hover:text-emerald-600 focus:outline-none lg:hidden mr-4 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>

                        <h1 class="text-lg font-bold text-gray-800 tracking-tight hidden sm:block">SIMPER <span class="font-normal text-gray-500 text-sm ml-1">(Sistem Informasi Perpustakaan)</span></h1>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="hidden sm:flex flex-col items-end">
                            <span class="text-sm font-medium text-gray-900"> <span class="uppercase font-bold text-emerald-600">{{ Auth::user()->roles->first()?->name ?? 'User' }}</span></span>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-emerald-500 to-teal-500 text-white flex items-center justify-center font-bold text-lg shadow-md border-2 border-white">
                            {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto bg-gray-50/50 p-4 sm:p-6 lg:p-8">
                    @isset($header)
                        <div class="mb-6">
                            {{ $header }}
                        </div>
                    @endisset
                    
                    {{ $slot }}
                </main>
            </div>
        </div>
        
        @stack('scripts')
        
        @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    if (window.Swal) {
                        window.Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: "{{ session('success') }}",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    }
                });
            </script>
        @endif
        
        @if(session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    if (window.Swal) {
                        window.Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: "{{ session('error') }}",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    }
                });
            </script>
        @endif
    </body>
</html>
