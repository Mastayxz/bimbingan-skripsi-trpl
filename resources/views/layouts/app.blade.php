<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 flex flex-col min-h-screen">
    <!-- Navbar -->
    <nav
        class="sticky top-0 z-50 bg-white dark:bg-gray-800 text-black dark:text-white shadow-md border-b border-gray-500">
        <div class="flex justify-between items-center px-6 py-3">
            <!-- Logo dan Judul Sistem -->
            <div class="flex items-center space-x-3">
                <!-- Sidebar Toggle Button (Always Visible) -->
                <button id="sidebarToggle"
                    class="p-2 bg-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-300 lg:hidden dark:bg-gray-800 dark:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-12">
                <span class="text-xl font-bold dark:text-white">SIBIMOLI</span>
            </div>

            <!-- Informasi Pengguna -->
            <div class="flex items-center space-x-6">
                <button id="theme-toggle" type="button"
                    class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 border-2 border-gray-300 dark:border-gray-600 focus:border-blue-500 transition-all duration-300">
                    <!-- Ikon mode gelap -->
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <!-- Ikon mode terang -->
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                            fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </button>

                <!-- Avatar dan Nama Pengguna -->
                <div class="flex items-center space-x-3">
                    <div
                        class="flex items-center justify-center h-10 w-10 rounded-full bg-gray-100 text-gray-900 font-bold text-sm border-2 border-gray-800 dark:border-gray-100 dark:bg-gray-800 dark:text-white">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="hidden lg:block text-sm">
                        <h3 class="font-medium">{{ Auth::user()->name }}</h3>
                        <span class="text-green-400 font-semibold">● ONLINE</span>
                    </div>
                </div>

            </div>

        </div>
    </nav>

    <!-- Main Layout -->
    <div class="flex flex-col lg:flex-row">
        <!-- Sidebar -->
        <div id="sidebar"
            class="fixed top-0 left-0 w-72 bg-white dark:bg-gray-800 text-black dark:text-white p-6 shadow-md border-r border-gray-500 h-full transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-40 mt-16 lg:mt-16">
            <!-- Profile Section -->
            <div class="flex flex-row items-center mb-8">
                <div
                    class="flex items-center justify-center h-20 w-24 bg-gray-700 text-white font-bold text-lg border-2 border-white">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="ml-8"> <!-- Margin kiri diperbesar -->
                    <a href="{{ route('profile.edit') }}" class="font-semibold text-md hover:text-blue-400">
                        {{ Auth::user()->name }}
                    </a>
                </div>
            </div>


            <!-- Sidebar Menu -->
            <ul class="space-y-2 font-medium">

                @auth
                    @if (auth()->user()->hasRole('admin') && auth()->user()->hasRole('dosen'))
                        <ul class="space-y-2">
                            @if (auth()->user()->hasRole('admin'))
                                <!-- Dropdown Menu Admin -->
                                <li class="relative">
                                    <button id="adminDropdown"
                                        class="flex items-center w-full px-4 py-2 text-left text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i class="fas fa-tachometer-alt w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                                        <span class="ml-3">Admin/Kaprodi</span>
                                        <i class="fas fa-chevron-down ml-auto"></i>
                                    </button>
                                    <ul id="adminMenu"
                                        class="hidden mt-2 space-y-2 bg-white rounded-lg  dark:bg-gray-800 {{ request()->routeIs('dashboard.admin', 'admin.mahasiswa', 'admin.dosen', 'admin.proposal.index', 'admin.skripsi.index', 'admin.bimbingan.index') ? 'active-admin' : '' }}">
                                        <li>
                                            <a href="{{ route('dashboard.admin') }}"
                                                class="block px-4 py-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('dashboard.admin') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                                <i
                                                    class="fas fa-tachometer-alt w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                                                <span class="ml-3">Dashboard</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.mahasiswa') }}"
                                                class="block px-4 py-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('admin.mahasiswa') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                                <i
                                                    class="fas fa-user-graduate w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                                                <span class="ml-3">Daftar Mahasiswa</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.dosen') }}"
                                                class="block px-4 py-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('admin.dosen') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                                <i
                                                    class="fas fa-chalkboard-teacher w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                                                <span class="ml-3">Daftar Dosen</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.proposal.index') }}"
                                                class="block px-4 py-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('admin.proposal.index') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                                <i class="fas fa-file-alt w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                                                <span class="ml-3">Daftar Proposal</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.skripsi.index') }}"
                                                class="block px-4 py-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('admin.skripsi.index') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                                <i class="fas fa-file-alt w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                                                <span class="ml-3">Daftar Skripsi</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.bimbingan.index') }}"
                                                class="block px-4 py-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('admin.bimbingan.index') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                                <i class="fas fa-comments w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                                                <span class="ml-3">Daftar Bimbingan Skripsi</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.penilaian.index') }}"
                                                class="block px-4 py-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('admin.penilaian.index') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                                <i
                                                    class="fas fa-clipboard-list w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                                                <span class="ml-3">Daftar Nilai</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            <hr>

                            @if (auth()->user()->hasRole('dosen'))
                                <!-- Dropdown Menu Dosen -->
                                <li class="relative">
                                    <button id="dosenDropdown"
                                        class="flex items-center w-full px-4 py-2 text-left text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i class="fas fa-user-graduate w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                                        <span class="ml-3">Dosen</span>
                                        <i class="fas fa-chevron-down ml-auto"></i>
                                    </button>
                                    <ul id="dosenMenu"
                                        class="hidden mt-2 space-y-2 bg-white rounded-lg dark:bg-gray-800 {{ request()->routeIs('dashboard.dosen', 'dosen.proposal.index', 'skripsi.index', 'bimbingan.index') ? 'active-dosen' : '' }}">
                                        <li>
                                            <a href="{{ route('dashboard.dosen') }}"
                                                class="flex items-center px-4 py-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('dashboard.dosen') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                                <i
                                                    class="fas fa-tachometer-alt w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                                                <span class="ml-3">Dashboard Dosen</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('skripsi.index') }}"
                                                class="flex items-center px-4 py-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('skripsi.index') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                                <i class="fas fa-file-alt w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                                                <span class="ml-3">Daftar Skripsi</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('bimbingan.index') }}"
                                                class="flex items-center px-4 py-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('bimbingan.index') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                                <i class="fas fa-comments w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                                                <span class="ml-3">Daftar Bimbingan</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('dosen.proposal.index') }}"
                                                class="flex items-center px-4 py-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('dosen.proposal.index') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                                <i class="fas fa-file-alt w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                                                <span class="ml-3">Daftar Proposal</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('dosen.penilaian.index') }}"
                                                class="block px-4 py-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('dosen.penilaian.index') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                                <i
                                                    class="fas fa-clipboard-list w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                                                <span class="ml-3">Daftar Nilai</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    @else
                        @role('admin')
                            <li>
                                <a href="{{ route('dashboard.admin') }}"
                                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('dashboard.admin') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                    <i
                                        class="fas fa-tachometer-alt w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                                    <span class="ms-3">Dashboard Admin</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.periode.index') }}"
                                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('admin.periode.index') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                    <i
                                        class="fas fa-user-graduate w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                                    <span class="ms-3">Periode</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.mahasiswa') }}"
                                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('admin.mahasiswa') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                    <i
                                        class="fas fa-user-graduate w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                                    <span class="ms-3">Daftar Mahasiswa</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.dosen') }}"
                                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('admin.dosen') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                    <i
                                        class="fas fa-chalkboard-teacher w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                                    <span class="ms-3">Daftar Dosen</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.skripsi.index') }}"
                                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('admin.skripsi.index') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                    <i
                                        class="fas fa-file-alt w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                                    <span class="ms-3">Daftar Skripsi</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.proposal.index') }}"
                                    class="block px-4 py-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('admin.proposal.index') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                    <i class="fas fa-file-alt w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                                    <span class="ml-3">Daftar Proposal</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.bimbingan.index') }}"
                                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('admin.bimbingan.index') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                    <i
                                        class="fas fa-file-alt w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                                    <span class="ms-3">Daftar Bimbingan Skripsi</span>
                                </a>
                            </li>
                            <br>
                        @endrole

                        @role('mahasiswa')
                            <li>
                                <a href="{{ route('dashboard.mahasiswa') }}"
                                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('dashboard.mahasiswa') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                    <i
                                        class="fas fa-tachometer-alt w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                                    <span class="ms-3">Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('proposal.create') }}"
                                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('proposal.create') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                    <i
                                        class="fas fa-file-alt w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                                    <span class="ms-3">Daftarkan Proposal</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('proposal.index') }}"
                                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('proposal.index') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                    <i
                                        class="fas fa-file-alt w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                                    <span class="ms-3">Daftar Proposal</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('bimbingan.index') }}"
                                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('bimbingan.index') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                    <i
                                        class="fas fa-comments w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                                    <span class="ms-3">Daftar Bimbingan</span>
                                </a>
                            </li>
                        @endrole

                        @role('dosen')
                            <li>
                                <a href="{{ route('dashboard.dosen') }}"
                                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('dashboard.dosen') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                    <i
                                        class="fas fa-tachometer-alt w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                                    <span class="ms-3">Dashboard Dosen</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('dosen.proposal.index') }}"
                                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('dosen.proposal.index') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                    <i
                                        class="fas fa-file-alt w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                                    <span class="ms-3">Daftar Proposal</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('skripsi.index') }}"
                                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('skripsi.index') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                    <i
                                        class="fas fa-file-alt w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                                    <span class="ms-3">Daftar Skripsi</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('bimbingan.index') }}"
                                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('bimbingan.index') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                    <i
                                        class="fas fa-comments w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                                    <span class="ms-3">Daftar Bimbingan</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('dosen.penilaian.index') }}"
                                    class="block px-4 py-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('dosen.penilaian.index') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                    <i class="fas fa-clipboard-list w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                                    <span class="ml-3">Daftar Nilai</span>
                                </a>
                            </li>
                        @endrole
                    @endif
                @endauth
            </ul>
            <!-- Logout -->
            <div class="mt-6 justify-end ">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="block py-2 px-4 rounded w-full bg-red-500 text-white p-2  dark:hover:bg-red-700">
                        Log Out
                    </button>
                </form>
            </div>

        </div>
        <div class="relative w-full h-full overflow-y-auto bg-gray-100 dark:bg-gray-900 lg:ml-72">
            <main class="w-full px-4 lg:px-8 py-6">
                <div class="max-w-screen-2xl mx-auto">
                    <!-- Konten di sini -->
                    @section('breadcrumb')
                    @show
                    @if (session('error'))
                        <div class="bg-red-500 dark:bg-red-700 text-white p-4 rounded-lg mb-6">
                            {{ session('error') }}
                        </div>
                    @endif
                    {{ $slot ?? '' }}
                    @yield('content')
                </div>
            </main>
        </div>

    </div>


    <!-- Footer -->
    <footer
        class="bg-white dark:bg-gray-800 text-black dark:text-white py-4 border-t border-gray-300 dark:border-gray-700 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <!-- Copyright -->
            <div>
                <p class="text-sm">&copy; {{ date('Y') }} Politeknik Negeri Bali. All Rights Reserved.</p>
            </div>

            <!-- Additional Links -->
            <div class="flex space-x-6">
                <a href="#" class="text-sm hover:text-gray-300">Privacy Policy</a>
                <a href="#" class="text-sm hover:text-gray-300">Terms of Service</a>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

            // Tentukan tema awal berdasarkan localStorage atau preferensi sistem
            const isDarkMode =
                localStorage.getItem('color-theme') === 'dark' ||
                (!localStorage.getItem('color-theme') && window.matchMedia('(prefers-color-scheme: dark)').matches);

            // Atur ikon awal berdasarkan tema
            if (isDarkMode) {
                document.documentElement.classList.add('dark');
                themeToggleLightIcon.classList.remove('hidden');
            } else {
                document.documentElement.classList.remove('dark');
                themeToggleDarkIcon.classList.remove('hidden');
            }

            var themeToggleBtn = document.getElementById('theme-toggle');

            themeToggleBtn.addEventListener('click', function() {
                // Toggle ikon di dalam tombol
                themeToggleDarkIcon.classList.toggle('hidden');
                themeToggleLightIcon.classList.toggle('hidden');

                // Periksa dan atur tema berdasarkan kondisi saat ini
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            });
        });


        document.addEventListener('DOMContentLoaded', () => {
            const dropdowns = [{
                    buttonId: 'adminDropdown',
                    menuId: 'adminMenu',
                    activeClass: 'active-admin'
                },
                {
                    buttonId: 'dosenDropdown',
                    menuId: 'dosenMenu',
                    activeClass: 'active-dosen'
                }
            ];

            dropdowns.forEach(({
                buttonId,
                menuId,
                activeClass
            }) => {
                const button = document.getElementById(buttonId);
                const menu = document.getElementById(menuId);

                // Tetap buka jika menu aktif
                if (menu.classList.contains(activeClass)) {
                    menu.classList.remove('hidden');
                }

                button.addEventListener('click', () => {
                    menu.classList.toggle('hidden'); // Toggle visibility
                });

                // Tutup dropdown jika klik di luar menu
                document.addEventListener('click', (event) => {
                    if (!button.contains(event.target) && !menu.contains(event.target)) {
                        menu.classList.add('hidden');
                    }
                });
            });
        });


        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });
    </script>

</body>

</html>
