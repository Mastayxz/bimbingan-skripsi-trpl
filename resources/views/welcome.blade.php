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

    <!-- Main Section -->
    <section class="bg-white py-12">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                Selamat Datang di Sistem Bimbingan Skripsi PNB
            </h1>
            <p class="text-lg md:text-xl text-gray-600 mb-6">
                Sistem ini bertujuan untuk mempermudah mahasiswa dan dosen dalam proses bimbingan skripsi. Dengan sistem ini,
                mahasiswa dapat mengajukan topik, mengatur jadwal bimbingan, dan memonitor perkembangan skripsi mereka secara mudah dan efisien.
            </p>
            <a href="{{ route('login') }}" class="text-white bg-blue-600 hover:bg-blue-700 font-medium py-3 px-6 rounded-lg shadow-md">
                Mulai Bimbingan
            </a>
        </div>
    </section>

    <!-- About System Section -->
    <section class="bg-gray-100 py-12">
        <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left: About Info -->
            <div class="flex flex-col justify-center">
                <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-4">Tentang Sistem</h2>
                <p class="text-lg text-gray-600 mb-4">
                    Sistem Bimbingan Skripsi PNB dirancang untuk memudahkan proses komunikasi dan pengelolaan bimbingan antara
                    mahasiswa dan dosen. Dengan fitur-fitur seperti penjadwalan otomatis, pengajuan topik, dan pengiriman laporan,
                    sistem ini diharapkan dapat meningkatkan efektivitas dan efisiensi bimbingan skripsi.
                </p>
                <ul class="list-disc pl-6 text-lg text-gray-600">
                    <li>Pengajuan topik skripsi yang lebih cepat</li>
                    <li>Penjadwalan bimbingan yang fleksibel</li>
                    <li>Pengiriman laporan progres secara berkala</li>
                    <li>Feedback langsung dari dosen pembimbing</li>
                </ul>
            </div>
            <!-- Right: Image of Mentoring -->
            <div class="flex justify-center items-center">
                <!-- Gambar Unsplash dengan ukuran lebih besar -->
                <img src="{{ asset('images/Dosen-pembimbing-skripsi.jpg') }}" alt="Logo" class="h-100 w-full rounded-lg shadow-lg">
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white py-4 mt-12">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Sistem Bimbingan Skripsi PNB. All Rights Reserved.</p>
        </div>
    </footer>

</body>

</html>
