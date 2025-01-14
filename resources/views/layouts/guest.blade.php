<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body 
    class="font-sans text-gray-900 antialiased" 
    style="background-image: url('{{ asset('images/foto_login.jpg') }}'); background-size: cover; background-repeat: no-repeat; background-position: center;">

    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-6 bg-opacity-70 bg-gray-900">
        <!-- Main content area -->
        <div class="flex flex-col items-center justify-center w-full sm:max-w-md">
            <!-- Logo dan Teks Berdampingan -->
            <div class="flex items-center justify-center gap-x-4">
                <!-- Logo -->
                <a href="/">
                    <x-application-logo class="w-16 h-16 fill-current text-gray-500" />
                </a>
                <!-- Teks -->
                <div>
                    <h2 class="text-3xl font-bold text-white text-left">SIBIMOLI</h2>
                    <p class="text-lg text-gray-300 text-left">Sistem Bimbingan Skripsi Online PNB</p>
                </div>
            </div>
        </div>
    
        <!-- Form Login -->
        <div class="w-full sm:max-w-md bg-white shadow-md rounded-lg border border-gray-200 px-8 py-6 mt-8">
            <!-- Slot content -->
            {{ $slot }}
        </div>
    </div>
    
    
</body>


</html>
