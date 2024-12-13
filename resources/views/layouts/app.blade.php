<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 flex flex-col min-h-screen">
    <!-- Navbar -->
    <div class="bg-blue-600 text-white shadow-md border-b border-gray-300 sticky top-0 z-50">
        @include('layouts.navigation')
    </div>

    <!-- Main Layout -->
    <div class="flex">
        <!-- Sidebar -->
        <div class="fixed top-16 left-0 w-64 bg-white text-black p-6 flex flex-col shadow-md border-r border-gray-300 h-[calc(100vh-4rem)]">
            <!-- Profile Section -->
            <div class="flex flex-col items-center mb-8">
                <img class="h-20 w-20 rounded-full border-4 border-white" 
                    src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60" 
                    alt="Profile Picture">
                <div class="mt-3 text-center">
                    <a href="{{ route('profile.edit') }}" class="font-semibold text-lg hover:text-blue-400">
                        {{ Auth::user()->name }}
                    </a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <ul class="flex-grow">
                @auth
                    @role('admin')
                        <li><a href="{{ route('dashboard.admin') }}" class="block py-2 px-4 rounded hover:bg-blue-700">Dashboard Admin</a></li>
                        <li><a href="{{ route('admin.mahasiswa') }}" class="block py-2 px-4 rounded hover:bg-blue-700">Mahasiswa</a></li>
                        <li><a href="{{ route('admin.dosen') }}" class="block py-2 px-4 rounded hover:bg-blue-700">Dosen</a></li>
                        <li><a href="{{ route('admin.skripsi.index') }}" class="block py-2 px-4 rounded hover:bg-blue-700">Skripsi</a></li>
                    @endrole

                    @role('mahasiswa')
                        <li><a href="{{ route('dashboard.mahasiswa') }}" class="block py-2 px-4 rounded hover:bg-blue-700">Dashboard Mahasiswa</a></li>
                        <li><a href="{{ route('skripsi.create') }}" class="block py-2 px-4 rounded hover:bg-blue-700">Buat Skripsi</a></li>
                    @endrole
                @endauth
            </ul>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block py-2 px-4 rounded text-red-500 hover:bg-blue-700 w-full">
                    Log Out
                </button>
            </form>
        </div>

        <!-- Content Area -->
        <div class="flex-1 bg-gray-100 p-6 ml-64">
            <div class="content-wrapper">
                {{ $slot ?? '' }}
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white text-black py-4 border-t border-gray-300">
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
</body>
</html>
