<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800 font-sans">

    <!-- Navbar -->
    <header class="bg-white shadow sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo dan Nama Sistem -->
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Sistem" class="w-12 h-12">
                <span class="text-xl font-semibold text-gray-700">Sistem Bimbingan Skripsi PNB</span>
            </div>
            <!-- Login & Register or User Profile -->
            <div class="flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900 font-medium">Login</a>
                    <a href="{{ route('register') }}" class="text-white bg-blue-600 hover:bg-blue-700 font-medium py-2 px-4 rounded">
                        Register
                    </a>
                @else
                    <div class="relative">
                        <button class="flex items-center text-gray-700 hover:text-gray-900 font-medium focus:outline-none">
                            {{ Auth::user()->name }}
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white border rounded shadow-lg hidden group-hover:block">
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Dashboard</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-blue-600 text-white py-20">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl font-bold mb-4">Selamat Datang di Sistem Bimbingan Skripsi PNB</h1>
            <p class="text-lg mb-8">Platform terbaik untuk membantu Anda dalam menyelesaikan skripsi dengan bimbingan yang optimal.</p>
            <a href="{{ route('register') }}" class="bg-white text-blue-600 font-medium py-2 px-4 rounded hover:bg-gray-100">Daftar Sekarang</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold">Fitur Unggulan</h2>
                <p class="text-gray-600">Berikut adalah beberapa fitur unggulan yang kami tawarkan</p>
            </div>
            <div class="flex flex-wrap -mx-4">
                <div class="w-full md:w-1/3 px-4 mb-8">
                    <div class="bg-white p-6 rounded shadow">
                        <i class="fas fa-chalkboard-teacher text-blue-600 text-4xl mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Bimbingan Online</h3>
                        <p class="text-gray-600">Dapatkan bimbingan secara online dari dosen pembimbing Anda kapan saja dan di mana saja.</p>
                    </div>
                </div>
                <div class="w-full md:w-1/3 px-4 mb-8">
                    <div class="bg-white p-6 rounded shadow">
                        <i class="fas fa-file-alt text-blue-600 text-4xl mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Manajemen Dokumen</h3>
                        <p class="text-gray-600">Kelola dokumen skripsi Anda dengan mudah dan terorganisir.</p>
                    </div>
                </div>
                <div class="w-full md:w-1/3 px-4 mb-8">
                    <div class="bg-white p-6 rounded shadow">
                        <i class="fas fa-calendar-alt text-blue-600 text-4xl mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Jadwal Bimbingan</h3>
                        <p class="text-gray-600">Atur jadwal bimbingan dengan dosen pembimbing Anda secara efisien.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="bg-gray-100 py-20">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-4">Siap untuk memulai?</h2>
            <p class="text-gray-600 mb-8">Bergabunglah dengan kami dan mulai perjalanan skripsi Anda dengan bimbingan terbaik.</p>
            <a href="{{ route('register') }}" class="bg-blue-600 text-white font-medium py-2 px-4 rounded hover:bg-blue-700">Daftar Sekarang</a>
        </div>
    </section>

</body>

</html>
