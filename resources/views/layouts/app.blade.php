<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 flex flex-col min-h-screen ">
    <!-- Navbar -->
    <div class="bg-blue-600 text-white shadow-md border-b border-gray-300 sticky top-0 z-50">
        @include('layouts.navigation')
    </div>

    <!-- Main Layout -->
    <div class="flex flex-1">
        <!-- Sidebar -->
        <div class="fixed top-16 left-0 w-64 bg-gray-100 dark:bg-gray-800 text-black dark:text-white p-6 flex flex-col shadow-md border-r border-gray-500 h-[calc(100vh-4rem)]">
            <!-- Profile Section -->
            <div class="flex flex-row items-left mb-8">
                <div class="flex items-center justify-center h-20 w-24 bg-gray-700 text-white font-bold text-lg border-2 border-white">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="ml-3">
                    <a href="{{ route('profile.edit') }}" class="font-semibold text-md hover:text-blue-400">
                        {{ Auth::user()->name }}
                    </a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <ul class="space-y-2 font-medium">
                <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                </button>
                @auth
                    @role('admin')
                        <li>
                            <a href="{{ route('dashboard.admin') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('dashboard.admin') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                <i class="fas fa-tachometer-alt w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                                <span class="ms-3">Dashboard Admin</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.mahasiswa') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('admin.mahasiswa') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                <i class="fas fa-user-graduate w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                                <span class="ms-3">Daftar Mahasiswa</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.dosen') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('admin.dosen') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                <i class="fas fa-chalkboard-teacher w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                                <span class="ms-3">Daftar Dosen</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.skripsi.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('admin.skripsi.index') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                <i class="fas fa-file-alt w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                                <span class="ms-3">Daftar Skripsi</span>
                            </a>
                        </li>
                        <br>
                    @endrole

                    @role('mahasiswa')
                        <li>
                            <a href="{{ route('dashboard.mahasiswa') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('dashboard.mahasiswa') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                <i class="fas fa-tachometer-alt w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                                <span class="ms-3">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('proposal.create') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('proposal.create') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                <i class="fas fa-file-alt w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                                <span class="ms-3">Daftarkan Proposal</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('bimbingan.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('bimbingan.index') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                <i class="fas fa-comments w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                                <span class="ms-3">Daftar Bimbingan</span>
                            </a>
                        </li>
                    @endrole

                    @role('dosen')
                        <li>
                            <a href="{{ route('dashboard.dosen') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('dashboard.dosen') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                <i class="fas fa-tachometer-alt w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                                <span class="ms-3">Dashboard Dosen</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dosen.proposal.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('dosen.proposal.index') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                <i class="fas fa-file-alt w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                                <span class="ms-3">Daftar Proposal</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('skripsi.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('skripsi.index') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                <i class="fas fa-file-alt w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                                <span class="ms-3">Daftar Skripsi</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('bimbingan.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('bimbingan.index') ? 'bg-gray-300 dark:bg-gray-700 font-bold text-blue-600' : '' }}">
                                <i class="fas fa-comments w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                                <span class="ms-3">Daftar Bimbingan</span>
                            </a>
                        </li>
                    @endrole
                @endauth
            </ul>
            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block py-2 px-4 rounded text-red-400 hover:bg-gray-800 dark:hover:bg-gray-600 w-full hover:text-white">
                    Log Out
                </button>
            </form>
        </div>

        <!-- Content Area -->
        <div class="flex-1 bg-gray-200 dark:bg-gray-900 p-6 ml-64">
            <div class="content-wrapper">
                {{ $slot ?? '' }}
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 text-black dark:text-white py-4 border-t border-gray-300 dark:border-gray-700 mt-auto">
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
            var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

            // Change the icons inside the button based on previous settings
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                themeToggleLightIcon.classList.remove('hidden');
            } else {
                themeToggleDarkIcon.classList.remove('hidden');
            }

            var themeToggleBtn = document.getElementById('theme-toggle');

            themeToggleBtn.addEventListener('click', function() {

                // toggle icons inside button
                themeToggleDarkIcon.classList.toggle('hidden');
                themeToggleLightIcon.classList.toggle('hidden');

                // if set via local storage previously
                if (localStorage.getItem('color-theme')) {
                    if (localStorage.getItem('color-theme') === 'light') {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                    }

                // if NOT set via local storage previously
                } else {
                    if (document.documentElement.classList.contains('dark')) {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                    } else {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                    }
                }
            });
    </script>
</body>
</html>
