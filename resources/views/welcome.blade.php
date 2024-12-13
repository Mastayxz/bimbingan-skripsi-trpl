<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Bimbingan Skripsi PNB</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800 font-sans">

    <!-- Navbar -->
    <header class="bg-white shadow">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo dan Nama Sistem -->
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Sistem" class="w-12 h-12">
                <span class="text-xl font-semibold text-gray-700">Sistem Bimbingan Skripsi PNB</span>
            </div>
            <!-- Login & Register -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900 font-medium">Login</a>
                <a href="{{ route('register') }}" class="text-white bg-blue-600 hover:bg-blue-700 font-medium py-2 px-4 rounded">
                    Register
                </a>
            </div>
        </div>
    </header>

    

    <footer class="bg-blue-600 text-white py-4 mt-12">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Sistem Bimbingan Skripsi PNB. All Rights Reserved.</p>
        </div>
    </footer>

</body>

</html>
