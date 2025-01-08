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

<body class="font-sans text-gray-900 antialiased bg-gray-100">

    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-6">
        <!-- Main content area -->
        <div class="text-center mb-6 w-full sm:max-w-md">
            <!-- Logo -->
            <a href="/" class="mb-6">
                <x-application-logo class="w-32 h-32 mx-auto fill-current text-gray-500" />
            </a>
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Sistem Bimbingan Skripsi PNB</h2>
            <p class="text-lg text-gray-600 mb-8">Selamat datang di sistem bimbingan skripsi. Silakan login untuk melanjutkan.</p>
        </div>

        <!-- Form Login -->
        <div class="w-full sm:max-w-md bg-white shadow-md rounded-lg border border-gray-200 px-8 py-6">
            <!-- Slot content -->
            {{ $slot }}
        </div>
    </div>

</body>

</html>
